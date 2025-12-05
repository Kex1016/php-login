<?php
function getPdo(): PDO
{
    $dsn    = 'mysql:host=localhost;dbname=adatok;charset=utf8mb4';
    $dbUser = 'sanyi';
    $dbPass = 'sanyi';

    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            $dsn,
            $dbUser,
            $dbPass,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }
    return $pdo;
}

function decodePasswordFile(string $path = __DIR__ . '/password.txt'): array
{
    if (!file_exists($path)) {
        return ['error' => 'Jelszó fájl hiányzik'];
    }
    $encData = file_get_contents($path);
    if ($encData === false) {
        return ['error' => 'Nem olvasható a jelszó fájl'];
    }

    $shift   = [5, -14, 31, -9, 3];
    $decoded = '';
    $pos     = 0;

    $len = strlen($encData);
    for ($i = 0; $i < $len; $i++) {
        $byte = ord($encData[$i]);

        if ($byte === 0x0A) {
            $decoded .= "\n";
            $pos = 0;
            continue;
        }

        $shiftVal = $shift[$pos % count($shift)];
        $origByte = $byte - $shiftVal;
        $decoded .= chr($origByte);
        $pos++;
    }

    $creds = [];
    foreach (explode("\n", trim($decoded)) as $line) {
        if ($line === '') continue;
        [$u, $p] = explode('*', $line, 2);
        $creds[$u] = $p;
    }
    return $creds;
}

function authenticate(string $username, string $password, array $creds): array
{
    if (isset($creds['error'])) {
        return ['status' => false, 'msg' => $creds['error']];
    }

    if (!array_key_exists($username, $creds)) {
        return ['status' => false, 'msg' => 'Nincs ilyen felhasználó'];
    }
    if ($creds[$username] !== $password) {
        header('Refresh:3; url=https://police.hu');
        return ['status' => false, 'msg' => 'Hibás jelszó'];
    }
    return ['status' => true];
}

function getUserColor(string $username): ?string
{
    $pdo = getPdo();
    $stmt = $pdo->prepare('SELECT color FROM tabla WHERE username = :u');
    $stmt->execute([':u' => $username]);
    $row = $stmt->fetch();
    return $row['color'] ?? null;
}

function renderResult(string $username, string $color): string
{
    return "Sikeres bejelentkezés. A kedvenc színed: <strong>{$color}</strong>.";
}

function handleLogin(): string
{
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        return 'Hiányzó adat';
    }

    $creds = decodePasswordFile();

    $auth = authenticate($username, $password, $creds);
    if (!$auth['status']) {
        return $auth['msg'];
    }

    $color = getUserColor($username);
    if ($color === null) {
        return 'Nincs színinformáció';
    }

    return renderResult($username, $color);
}
?>
