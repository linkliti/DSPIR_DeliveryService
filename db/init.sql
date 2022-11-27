-- Fix Russian language
SET NAMES utf8mb4;
-- Tables
DROP DATABASE IF EXISTS `DeliveryService`;
CREATE DATABASE IF NOT EXISTS `DeliveryService` DEFAULT CHARACTER SET utf8;
CREATE USER IF NOT EXISTS 'user' @'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON DeliveryService.* TO 'user' @'%';
FLUSH PRIVILEGES;
USE `DeliveryService`;