-- adatbázis létrehozása
CREATE DATABASE IF NOT EXISTS adatok CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- használjuk az új adatbázist
USE adatok;

-- tábla létrehozása
CREATE TABLE IF NOT EXISTS tabla (
    id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username  VARCHAR(255) NOT NULL UNIQUE,
    color     VARCHAR(50)  NOT NULL
) ENGINE=InnoDB;

-- kezdeti adatok (a megadott színek)
INSERT INTO tabla (username, color) VALUES
('katika@gmail.com',   'piros'),
('arpi40@freemail.hu','zold'),
('zsanettka@hotmail.com','sarga'),
('hatizsak@protonmail.com','kek'),
('terpeszterez@citromail.hu','fekete'),
('nagysanyi@gmail.hu','feher')
ON DUPLICATE KEY UPDATE color = VALUES(color);

-- 3.  MySQL‑felhasználó létrehozása (jelszó: sanyi)
CREATE USER IF NOT EXISTS 'sanyi'@'localhost' IDENTIFIED BY 'sanyi';

-- 4.  Jogosultságok: csak SELECT, INSERT, UPDATE, DELETE a tabla táblára
GRANT SELECT, INSERT, UPDATE, DELETE ON adatok.tabla TO 'sanyi'@'localhost';

-- 5.  (opcionális) a változások azonnali érvénybe lépése
FLUSH PRIVILEGES;
