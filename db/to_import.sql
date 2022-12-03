DROP DATABASE IF EXISTS `DeliveryService`;
CREATE DATABASE IF NOT EXISTS `DeliveryService` DEFAULT CHARACTER SET utf8;
USE `DeliveryService`;
-- Таблица `PVZ`
CREATE TABLE IF NOT EXISTS `Pvzs` (
    `id_Pvz` INT NOT NULL AUTO_INCREMENT,
    `PVZ` VARCHAR(45) NOT NULL,
    `Address` VARCHAR(100) NOT NULL,
    `WorkersAmount` INT NOT NULL,
    `PVZ_Schedule` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id_Pvz`)
)  ENGINE=INNODB;

-- Таблица `Clients`
CREATE TABLE IF NOT EXISTS `Clients` (
    `id_Client` INT NOT NULL AUTO_INCREMENT,
    `Fullname` VARCHAR(45) NOT NULL,
    `PhoneNumber` VARCHAR(45) NOT NULL,
    `Email` VARCHAR(45) NOT NULL,
    `ClientType` INT NOT NULL,
    PRIMARY KEY (`id_Client`)
) ENGINE = InnoDB;

-- Таблица `Vehicles`
CREATE TABLE IF NOT EXISTS `Vehicles` (
    `id_Vehicle` INT NOT NULL AUTO_INCREMENT,
    `Vehicle` VARCHAR(45) NOT NULL,
    `VIN` VARCHAR(45) NOT NULL,
    `GovNumber` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id_Vehicle`)
) ENGINE = InnoDB;

-- Таблица `Workers`
CREATE TABLE IF NOT EXISTS `Workers` (
    `id_Worker` INT NOT NULL AUTO_INCREMENT,
    `User_login` VARCHAR(45) NOT NULL,
    `User_pass` VARCHAR(128) NOT NULL,
    `Fullname` VARCHAR(45) NOT NULL,
    `Post` VARCHAR(45) NOT NULL,
    `Salary` FLOAT NOT NULL,
    `WorkerType` INT NOT NULL,
    `Shift` VARCHAR(45) NOT NULL,
    `Statistic` VARCHAR(45) NOT NULL DEFAULT 0,
    `Revenue` FLOAT NOT NULL DEFAULT 0,
    `Vehicles_id_Vehicle` INT NOT NULL DEFAULT 1,
    PRIMARY KEY (`id_Worker`),
    FOREIGN KEY (`Vehicles_id_Vehicle`) REFERENCES `Vehicles` (`id_Vehicle`)
) ENGINE = InnoDB;

-- Таблица `Warehouse`
CREATE TABLE IF NOT EXISTS `Positions` (
    `id_Position` INT NOT NULL AUTO_INCREMENT,
    `Position` VARCHAR(45) NOT NULL,
    `PositionType` VARCHAR(45) NOT NULL,
    `PositionLocation` VARCHAR(45) NOT NULL,
    `Workers_id_Worker` INT NOT NULL,
    PRIMARY KEY (`id_Position`),
    FOREIGN KEY (`Workers_id_Worker`) REFERENCES `Workers` (`id_Worker`)
) ENGINE = InnoDB;

-- Таблица `Orders`
CREATE TABLE IF NOT EXISTS `Orders` (
    `id_Order` INT NOT NULL AUTO_INCREMENT,
    `Positions_id_Position` INT NOT NULL,
    `Clients_id_Client` INT NOT NULL,
    `Pvzs_id_Pvz` INT NOT NULL,
    `Workers_id_Worker` INT NOT NULL,
    `DeliveryAmount` FLOAT NOT NULL,
    `DeliveryDateTime` DATETIME NOT NULL,
    `DeliveryStatus` INT NOT NULL,
    PRIMARY KEY (`id_Order`, `Positions_id_Position`),
    FOREIGN KEY (`Pvzs_id_Pvz`) REFERENCES `Pvzs` (`id_Pvz`),
    FOREIGN KEY (`Clients_id_Client`) REFERENCES `Clients` (`id_Client`),
    FOREIGN KEY (`Positions_id_Position`) REFERENCES `Positions` (`id_Position`),
    FOREIGN KEY (`Workers_id_Worker`) REFERENCES `Workers` (`id_Worker`)
) ENGINE = InnoDB;
-- Data
USE `DeliveryService`;
-- Таблицы
INSERT INTO Clients (Fullname, PhoneNumber, Email, ClientType)
VALUES ( 'Яндульская Марианна Игнатьевна', '+7 (959) 746-44-72', 'marianna59@yandex.ru', 0 ),
( 'Янишпольская Алиса Сергеевна', '+7 (930) 732-56-48', 'alisa43@outlook.com', 2 ),
( 'Фаммус Егор Степанович', '+7 (958) 271-76-69', 'egor.fammus@outlook.com', 1 ),
( 'Низамутдинов Василий Дмитриевич', '+7 (975) 305-75-77', 'vasiliy1987@gmail.com', 2 ),
( 'Вазова Инна Севастьяновна', '+7 (993) 648-20-44', 'inna.vazova@mail.ru', 1 );

INSERT INTO Vehicles (Vehicle, VIN, GovNumber)
VALUES ('Не водитель', ' ', ' '),
    ( 'Geely Emgrand EC7', 'KS6TV944473456755', 'С866ТК84' ),
    ('Audi A2', 'GX0VX855518853187', 'Е108УВ46'),
    ('Audi A3', 'KR8SF943860695598', 'М708ЕК18'),
    ('BMW X3 M', 'FX0HU884196530198', 'Х960НВ84'),
    ('BMW M5', 'YR9EG774652155467', 'В581ВЕ06');

INSERT INTO Pvzs (PVZ, Address, WorkersAmount, PVZ_Schedule)
VALUES ( 'Главный', 'Россия, Г. Москва, Большой Гнездниковский пер., 3', 27, '5/2' ),
    ( 'Восточный', 'Россия, Г. Москва, Кусковская ул., 17, стр. 1', 17, '5/2' ),
    ( 'Западный', 'Россия, Г. Москва, Союзная ул., 1В, Одинцовоподъезд №2, помещение №102', 12, '5/2' ),
    ( 'Северный', 'Россия, Г. Москва, Окружная ул., 13, Лобня', 7, '7/0' ),
    ( 'Южный', 'Россия, Г. Москва, Севастопольский просп., 51, корп. 2', 18, '5/2' );

-- https://www.web2generators.com/apache-tools/htpasswd-generator
INSERT INTO Workers ( User_login, User_pass, Fullname, Post, Salary, WorkerType, Shift, Statistic, Revenue, Vehicles_id_Vehicle )
VALUES ( 'worker1', '$apr1$xmdu072q$CjUBSyHrUCHp/1aL7FfIH/', 'Жиглов Данила Денисович', 'Администратор', 65000, 0, '5/2', 0, 0, 1 ),
    ( 'worker2', '$apr1$c9jygoun$piNJXQCsfku/8iyhTQRXd.', 'Новохацкий Константин Никитович', 'Водитель-экспедитор', 80000, 1, '5/2', 102, 236353, 4 ),
    ( 'worker3', '$apr1$rtbcn3ad$lq91jMi35l1WRDN.jhfjK1', 'Райан Томас Гослинг', 'Водитель-экспедитор', 120000, 1, '6/1', 156, 567263, 3 ),
    ( 'worker4', '$apr1$rpn1zq7g$HLsEH9eRimdorcvyC0NiK0', 'Осокина Виктория Прокловна', 'Менеджер', 40000, 1, '5/2', 0, 0, 1 ),
    ( 'worker5', '$apr1$lknzx08g$e3PQr0NXCNnOOGXziqkjW1', 'Бурда Настасья Всеволодовна', 'Бухгалтер', 60000, 1, '5/2', 0, 0, 1 ),
    ( 'worker6', '$apr1$wlhu2vpo$iWmX0o8WUoOIo75b.v4N71', 'Акимова Афанасия Петровна', 'Сборщик', 30000, 0, '3/3', 152, 0, 1 ),
    ( 'worker7', '$apr1$exmqzonl$hJYCvNP/C8S8odzEYSwJe/', 'Квасников Егор Арсеньевич', 'Сборщик', 45000, 1, '5/3', 364, 0, 1 );

INSERT INTO Positions ( Position, PositionType, PositionLocation, Workers_id_Worker )
VALUES ('Стул', 'Мебель', 'A1B1', 6),
    ('Игрушка Хаги-Ваги', 'Игрушки', 'A1B2', 7),
    ('Средство от кашля', 'Лекарство', 'A2B1', 6),
    ( 'Подушка длинная', 'Постельные принадлежности', 'A4B1', 6 ),
    ('Вода в бутылях', 'Вода', 'A1B3', 7),
    ('Игрушка Амогус', 'Игрушки', 'A2B4', 7);

INSERT INTO Orders ( Positions_id_Position, Clients_id_Client, Pvzs_id_Pvz, Workers_id_Worker, DeliveryAmount, DeliveryDateTime, DeliveryStatus )
VALUES (4, 3, 5, 2, 500, '20221030', 4),
    (5, 2, 4, 3, 560, '20221014', 3),
    (1, 1, 3, 3, 700, '20221016', 2),
    (2, 5, 2, 3, 300, '20221012', 1),
    (3, 4, 1, 2, 720, '20221031', 3),
    (6, 4, 1, 4, 790, '20221030', 5);

-- Процедуры получения таблиц
DROP PROCEDURE IF EXISTS getclientsTable;
DELIMITER /
CREATE PROCEDURE getclientsTable() BEGIN
SELECT *
FROM Clients;
END /
DELIMITER ;

DROP PROCEDURE IF EXISTS getordersTable;
DELIMITER /
CREATE PROCEDURE getordersTable() BEGIN
SELECT *
FROM Orders;
END /
DELIMITER ;

DROP PROCEDURE IF EXISTS getpvzsTable;
DELIMITER /
CREATE PROCEDURE getpvzsTable() BEGIN
SELECT *
FROM Pvzs;
END /
DELIMITER ;

DROP PROCEDURE IF EXISTS getvehiclesTable;
DELIMITER /
CREATE PROCEDURE getvehiclesTable() BEGIN
SELECT *
FROM Vehicles;
END /
DELIMITER ;

DROP PROCEDURE IF EXISTS getpositionsTable;
DELIMITER /
CREATE PROCEDURE getpositionsTable() BEGIN
SELECT *
FROM Positions;
END /
DELIMITER ;

DROP PROCEDURE IF EXISTS getworkersTable;
DELIMITER /
CREATE PROCEDURE getworkersTable() BEGIN
SELECT *
FROM Workers;
END /
DELIMITER ;
-- Процедура получения статуса
DROP PROCEDURE IF EXISTS getOrderStatus;
DELIMITER /
CREATE PROCEDURE getOrderStatus(id int) BEGIN
SELECT DeliveryStatus, friendly_DeliveryStatus(DeliveryStatus)
FROM Orders
WHERE id_Order = id;
END /
DELIMITER ;

-- Функция отображения статуса
DROP FUNCTION IF EXISTS friendly_DeliveryStatus;
DELIMITER /
CREATE FUNCTION friendly_DeliveryStatus(typenum int)
RETURNS	varchar(45) DETERMINISTIC
BEGIN
	DECLARE friendly_msg varchar(45);
    IF typenum = -1 THEN
		SET friendly_msg = 'Заказ отменен';
        RETURN(friendly_msg);
	ELSEIF typenum = 0 THEN
		SET friendly_msg = 'Обработка менеджером';
        RETURN(friendly_msg);
	ELSEIF typenum = 1 THEN
		SET friendly_msg = 'Обработка сборщиком';
        RETURN(friendly_msg);
	ELSEIF typenum = 2 THEN
		SET friendly_msg = 'В ожидании водителя';
        RETURN(friendly_msg);
	ELSEIF typenum = 3 THEN
		SET friendly_msg = 'Доставляется в пункт выдачи';
        RETURN(friendly_msg);
	ELSEIF typenum = 4 THEN
		SET friendly_msg = 'Доставлен в пункт выдачи';
        RETURN(friendly_msg);
	ELSEIF typenum = 5 THEN
		SET friendly_msg = 'Заказ получен клиентом';
        RETURN(friendly_msg);
	END IF;
END /
DELIMITER ;