<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    $msg = handleLogin();
    $success = (strpos($msg, 'Sikeres bejelentkezés') !== false);

    echo json_encode([
        'success' => $success,
        'message' => $msg,
        'color'   => $success ? extractColor($msg) : null
    ]);
    exit;
}

function extractColor(string $msg): ?string
{
    if (preg_match('/kedvenc színed:\s*<strong>([^<]+)<\/strong>/i', $msg, $m)) {
        return $m[1];
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
    <script type="module" src="/scripts/m3app.bundled.js"></script>
    <script type="module" src="/scripts/animation.module.js"></script>
</head>
<body>
    <m3-app>
        <div class="container">
            <div class="card">
                <h2>Bejelentkezés</h2>
                <form method="post" action="">
                    <div class="form-control">
                        <label>
                            <span class="text">Email</span>
                            <input type="email" name="username" required>
                        </label>
                    </div>
                    <div class="form-control">
                        <label>
                            <span class="text">Jelszó</span>
                            <input type="password" name="password" required>
                        </label>
                    </div>
                    <div class="submit-button">
                        <button type="submit">Belépés</button>
                    </div>
                </form>
            </div>
        </div>
    </m3-app>
    <script type="module" src="/scripts/app.module.js"></script>
</body>
</html>
