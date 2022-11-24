CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user' @'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON appDB.* TO 'user' @'%';
FLUSH PRIVILEGES;
USE appDB;
-- Fix Russian language
SET NAMES utf8mb4;
-- Tables
CREATE TABLE IF NOT EXISTS users (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    name CHAR(20) NOT NULL UNIQUE,
    password CHAR(40) NOT NULL,
    PRIMARY KEY (ID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE TABLE IF NOT EXISTS toys (
    ID INT(10) NOT NULL AUTO_INCREMENT,
    title VARCHAR(32) NOT NULL UNIQUE,
    description VARCHAR(256) NOT NULL,
    cost INT(6) NOT NULL,
    PRIMARY KEY (ID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- Admin (MD5)
-- https://www.web2generators.com/apache-tools/htpasswd-generator
INSERT INTO users (name, password)
VALUES (
        'iamadmin',
        '$apr1$6m1kplbd$vj70h1X3zQJy0tlp3JXKW0' -- mypass
    ),
    (
        'login',
        '$apr1$epobq07t$QlAR40n8JIhlPfgldEIXS.' -- password
    ),
    (
        'user',
        '$apr1$2c1lbz39$C0R15lfFdXaNm/LlR9iuI1' -- donotuse
    ),
    (
        'alex',
        '$apr1$tj5z9kdw$5ViDVDC6eU/5x6QhNvhEc/' -- securePWD
    );
-- Toys
INSERT INTO toys (title, description, cost)
VALUES (
        'Амогус',
        'Подозрительная игрушка для вашего ребенка!',
        420
    ),
    ('Эмодзи', 'Веселый эмодзи!', 900);