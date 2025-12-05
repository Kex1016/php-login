CREATE DATABASE IF NOT EXISTS adatok CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE adatok;

CREATE TABLE IF NOT EXISTS tabla (
    id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username  VARCHAR(255) NOT NULL UNIQUE,
    color     VARCHAR(50)  NOT NULL
) ENGINE=InnoDB;

INSERT INTO tabla (username, color) VALUES
('katika@gmail.com','piros'),
('arpi40@freemail.hu','zold'),
('zsanettka@hotmail.com','sarga'),
('hatizsak@protonmail.com','kek'),
('terpeszterez@citromail.hu','fekete'),
('nagysanyi@gmail.hu','feher')
ON DUPLICATE KEY UPDATE color = VALUES(color);

CREATE USER IF NOT EXISTS 'sanyi'@'localhost' IDENTIFIED BY 'sanyi';
GRANT SELECT, INSERT, UPDATE, DELETE ON adatok.tabla TO 'sanyi'@'localhost';
