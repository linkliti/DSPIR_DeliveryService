DROP DATABASE IF EXISTS `DeliveryService`;
CREATE DATABASE IF NOT EXISTS `DeliveryService` DEFAULT CHARACTER SET utf8mb4;
USE `DeliveryService`;

-- ----------------------------
-- Таблицы
-- ---------------------------
-- Таблица `PVZ`
CREATE TABLE IF NOT EXISTS `Pvzs` (
    `id_Pvz` INT NOT NULL AUTO_INCREMENT,
    `PVZ` VARCHAR(45) NOT NULL,
    `Address` VARCHAR(100) NOT NULL,
    `PVZ_Schedule` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id_Pvz`) ) ENGINE = INNODB;

-- Таблица `Clients`
CREATE TABLE IF NOT EXISTS `Clients` (
    `id_Client` INT NOT NULL AUTO_INCREMENT,
    `Fullname` VARCHAR(64) NOT NULL,
    `PhoneNumber` VARCHAR(20) NOT NULL,
    `Email` VARCHAR(64) NOT NULL,
    `ClientType` TINYINT NOT NULL,
    CONSTRAINT ClientTypeRange CHECK (ClientType BETWEEN 0 AND 2),
    PRIMARY KEY (`id_Client`) ) ENGINE = InnoDB;
-- Таблица `Vehicles`
CREATE TABLE IF NOT EXISTS `Vehicles` (
    `id_Vehicle` INT NOT NULL AUTO_INCREMENT,
    `Vehicle` VARCHAR(75) NOT NULL,
    `VIN` VARCHAR(30) NOT NULL,
    `GovNumber` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`id_Vehicle`) ) ENGINE = InnoDB;
-- Таблица `Workers`
CREATE TABLE IF NOT EXISTS `Workers` (
    `id_Worker` INT NOT NULL AUTO_INCREMENT,
    `User_login` VARCHAR(255) NOT NULL,
    `User_pass` VARCHAR(255) NOT NULL,
    `Fullname` VARCHAR(64) NOT NULL,
    `Post` VARCHAR(64) NOT NULL,
    `Salary` FLOAT NOT NULL,
    `WorkerType` TINYINT NOT NULL,
    `Shift` VARCHAR(10) NOT NULL,
    `Vehicles_id_Vehicle` INT NOT NULL DEFAULT 1,
    UNIQUE (`User_login`),
    CONSTRAINT WorkerTypeRange CHECK (WorkerType BETWEEN 0 AND 2),
    PRIMARY KEY (`id_Worker`),
    FOREIGN KEY (`Vehicles_id_Vehicle`) REFERENCES `Vehicles` (`id_Vehicle`) ) ENGINE = InnoDB;
-- Таблица `Positions`
CREATE TABLE IF NOT EXISTS `Positions` (
    `id_Position` INT NOT NULL AUTO_INCREMENT,
    `Position` VARCHAR(64) NOT NULL,
    `PositionType` VARCHAR(45) NOT NULL,
    `PositionLocation` VARCHAR(20) NOT NULL,
    `Workers_id_Worker` INT NOT NULL,
    PRIMARY KEY (`id_Position`),
    FOREIGN KEY (`Workers_id_Worker`) REFERENCES `Workers` (`id_Worker`) ) ENGINE = InnoDB;
-- Таблица `Orders`
CREATE TABLE IF NOT EXISTS `Orders` (
    `id_Order` INT NOT NULL AUTO_INCREMENT,
    `Positions_id_Position` INT NOT NULL,
    `Clients_id_Client` INT NOT NULL,
    `Pvzs_id_Pvz` INT NOT NULL,
    `Workers_id_Worker` INT NOT NULL,
    `DeliveryAmount` FLOAT NOT NULL,
    `DeliveryDate` DATE NOT NULL,
    `DeliveryStatus` TINYINT NOT NULL,
    UNIQUE (`Positions_id_Position`),
    CONSTRAINT DeliveryStatusRange CHECK (DeliveryStatus BETWEEN 0 AND 6),
    PRIMARY KEY (`id_Order`, `Positions_id_Position`),
    FOREIGN KEY (`Pvzs_id_Pvz`) REFERENCES `Pvzs` (`id_Pvz`),
    FOREIGN KEY (`Clients_id_Client`) REFERENCES `Clients` (`id_Client`),
    FOREIGN KEY (`Positions_id_Position`) REFERENCES `Positions` (`id_Position`),
    FOREIGN KEY (`Workers_id_Worker`) REFERENCES `Workers` (`id_Worker`) ) ENGINE = InnoDB;

-- ----------------------------
-- Процедуры
-- ----------------------------

-- Процедуры получения таблиц
-- DROP PROCEDURE IF EXISTS getclientsTable;
    DELIMITER /
CREATE PROCEDURE getclientsTable() BEGIN
    SELECT id_Client, Fullname, PhoneNumber, Email, friendly_ClientType(ClientType)
    FROM Clients;
END /
DELIMITER ;

-- DROP PROCEDURE IF EXISTS getordersTable;
DELIMITER /
CREATE PROCEDURE getordersTable() BEGIN
    SELECT id_Order, Positions_id_Position, Positions.Position, Clients_id_Client, Clients.Fullname, Pvzs_id_Pvz, Pvzs.PVZ, Orders.Workers_id_Worker, Workers.Fullname AS WFullname,    DeliveryAmount, friendly_DeliveryDate(DeliveryDate), DeliveryStatus , friendly_DeliveryStatus(DeliveryStatus)
    FROM Orders
    INNER JOIN Clients ON Clients.id_Client = Orders.Clients_id_Client
    INNER JOIN Pvzs ON Pvzs.id_PVZ = Orders.Pvzs_id_PVZ
    INNER JOIN Workers ON Workers.id_Worker = Orders.Workers_id_Worker
    INNER JOIN Positions ON Positions.id_Position = Orders.Positions_id_Position;
END /
DELIMITER ;

-- DROP PROCEDURE IF EXISTS getpvzsTable;
DELIMITER /
CREATE PROCEDURE getpvzsTable() BEGIN
    SELECT id_Pvz, PVZ, Address, PVZ_Schedule
    FROM Pvzs;
END /
DELIMITER ;

-- DROP PROCEDURE IF EXISTS getvehiclesTable;
DELIMITER /
CREATE PROCEDURE getvehiclesTable() BEGIN
    SELECT id_Vehicle, Vehicle, VIN, GovNumber
    FROM Vehicles;
END /
DELIMITER ;

-- DROP PROCEDURE IF EXISTS getpositionsTable;
DELIMITER /
CREATE PROCEDURE getpositionsTable() BEGIN
    SELECT id_Position, Position, PositionType, PositionLocation, Workers_id_Worker, Workers.Fullname
    FROM Positions
    INNER JOIN Workers ON Workers.id_Worker = Positions.Workers_id_Worker;
END /
DELIMITER ;

-- DROP PROCEDURE IF EXISTS getworkersTable;
DELIMITER /
CREATE PROCEDURE getworkersTable() BEGIN
    SELECT id_Worker, User_login, Fullname, friendly_Post(Post), Salary, friendly_WorkerType(WorkerType), Shift, Vehicles_id_Vehicle, Vehicles.Vehicle
    FROM Workers
    INNER JOIN Vehicles ON Vehicles.id_Vehicle = Workers.Vehicles_id_Vehicle;
END /
DELIMITER ;

-- Процедура получения статуса заказа
-- DROP PROCEDURE IF EXISTS getOrderStatus;
DELIMITER /
CREATE PROCEDURE getOrderStatus(id int) BEGIN
    SELECT DeliveryStatus, client_DeliveryStatus(id_Order, DeliveryStatus)
    FROM Orders
    WHERE id_Order = id;
END /
DELIMITER ;

-- Процедура получения данных пользователя
-- DROP PROCEDURE IF EXISTS getAuthData;
DELIMITER /
CREATE PROCEDURE getAuthData(login_input varchar(255)) BEGIN
    SELECT Fullname, User_pass, Post, id_Worker, WorkerType
    FROM Workers
    WHERE User_login = login_input;
END /
DELIMITER ;

-- ----------------------------
-- Функции
-- ----------------------------

-- Функция показа пользователю статуса заказа
-- DROP FUNCTION IF EXISTS client_DeliveryStatus;
DELIMITER /
CREATE FUNCTION client_DeliveryStatus(id int, orderStatus int)
    RETURNS	varchar(200) DETERMINISTIC
BEGIN
	DECLARE order_statusText VARCHAR(45);
	DECLARE order_pvzName VARCHAR(45);
	DECLARE order_pvzAddress VARCHAR(100);
	DECLARE order_date VARCHAR(10);
    SET order_statusText = (
        SELECT friendly_DeliveryStatus(DeliveryStatus)
        FROM Orders
        WHERE id_Order = id
    );
    IF OrderStatus >= 3 THEN
	    SET order_pvzName = (
            SELECT PVZ
            FROM Orders
            INNER JOIN Pvzs ON Pvzs.id_PVZ = Orders.Pvzs_id_PVZ
            WHERE id_Order = id
        );
        SET order_pvzAddress = (
            SELECT Address
            FROM Orders
                INNER JOIN Pvzs ON Pvzs.id_PVZ = Orders.Pvzs_id_PVZ
            WHERE id_Order = id
        );
        SET order_date = (
            SELECT friendly_DeliveryDate(DeliveryDate)
            FROM Orders
            WHERE id_Order = id
        );
        RETURN(CONCAT(order_statusText, '. <br>Пункт выдачи: ', order_pvzName, '. <br>Адрес: ', order_pvzAddress, '. <br>Дата доставки: ', order_date));
    ELSE RETURN(order_statusText);
    END IF;
END /
DELIMITER ;

-- Функции дружелюбных названий
-- DROP FUNCTION IF EXISTS friendly_DeliveryStatus;
DELIMITER /
CREATE FUNCTION friendly_DeliveryStatus(typenum int)
    RETURNS	varchar(45) DETERMINISTIC
BEGIN
	DECLARE friendly_msg varchar(45);
    IF typenum = 0 THEN
		SET friendly_msg = 'Заказ отменен';
        RETURN(friendly_msg);
	ELSEIF typenum = 1 THEN
		SET friendly_msg = 'Обработка менеджером';
        RETURN(friendly_msg);
	ELSEIF typenum = 2 THEN
		SET friendly_msg = 'Обработка сборщиком';
        RETURN(friendly_msg);
	ELSEIF typenum = 3 THEN
		SET friendly_msg = 'В ожидании водителя';
        RETURN(friendly_msg);
	ELSEIF typenum = 4 THEN
		SET friendly_msg = 'Доставляется в пункт выдачи';
        RETURN(friendly_msg);
	ELSEIF typenum = 5 THEN
		SET friendly_msg = 'Доставлен в пункт выдачи';
        RETURN(friendly_msg);
	ELSEIF typenum = 6 THEN
		SET friendly_msg = 'Заказ получен клиентом';
        RETURN(friendly_msg);
	END IF;
END /
DELIMITER ;

-- DROP FUNCTION IF EXISTS friendly_Post;
DELIMITER /
CREATE FUNCTION friendly_Post(typenum varchar(45))
    RETURNS	varchar(45) DETERMINISTIC
BEGIN
	DECLARE friendly_msg varchar(45);
    IF typenum = 'admin' THEN
		SET friendly_msg = 'admin (Администратор)';
        RETURN(friendly_msg);
	ELSEIF typenum = 'driver' THEN
		SET friendly_msg = 'driver (Водитель)';
        RETURN(friendly_msg);
	ELSEIF typenum = 'manager' THEN
		SET friendly_msg = 'manager (Менеджер)';
        RETURN(friendly_msg);
	ELSEIF typenum = 'assembler' THEN
		SET friendly_msg = 'assembler (Сборщик)';
        RETURN(friendly_msg);
	END IF;
    RETURN(typenum);
END /
DELIMITER ;

-- DROP FUNCTION IF EXISTS friendly_ClientType;
DELIMITER /
CREATE FUNCTION friendly_ClientType(typenum varchar(45))
    RETURNS	varchar(45) DETERMINISTIC
BEGIN
	DECLARE friendly_msg varchar(45);
    IF typenum = 0 THEN
		SET friendly_msg = '0 (Новый)';
        RETURN(friendly_msg);
	ELSEIF typenum = 1 THEN
		SET friendly_msg = '1 (Обычный)';
        RETURN(friendly_msg);
	ELSEIF typenum = 2 THEN
		SET friendly_msg = '2 (Льготный)';
        RETURN(friendly_msg);
	END IF;
END /
DELIMITER ;

-- DROP FUNCTION IF EXISTS friendly_WorkerType;
DELIMITER /
CREATE FUNCTION friendly_WorkerType(typenum varchar(45))
    RETURNS	varchar(45) DETERMINISTIC
BEGIN
	DECLARE friendly_msg varchar(45);
    IF typenum = 0 THEN
		SET friendly_msg = '0 (Уволен)';
        RETURN(friendly_msg);
	ELSEIF typenum = 1 THEN
		SET friendly_msg = '1 (Штатный)';
        RETURN(friendly_msg);
	ELSEIF typenum = 2 THEN
		SET friendly_msg = '2 (Внештатный)';
        RETURN(friendly_msg);
	END IF;
END /
DELIMITER ;

-- DROP FUNCTION IF EXISTS friendly_DeliveryDate;
DELIMITER /
CREATE FUNCTION friendly_DeliveryDate(typenum varchar(10))
    RETURNS	varchar(10) DETERMINISTIC
BEGIN
    RETURN(DATE_FORMAT(typenum, '%d.%m.%Y'));
END /
DELIMITER ;

-- ----------------------------
-- Триггеры
-- ----------------------------

-- Без пробелов в данных авторизации
-- DROP TRIGGER IF EXISTS WorkersDetectAuthWhitespaceINS;
DELIMITER /
CREATE TRIGGER WorkersDetectAuthWhitespaceINS BEFORE INSERT ON Workers FOR EACH ROW
BEGIN
	IF new.User_login LIKE '% %' OR new.User_pass LIKE '% %' THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Whitespaces in login or password are not allowed';
	END IF;
END /
DELIMITER ;
-- DROP TRIGGER IF EXISTS WorkersDetectAuthWhitespaceUPD;
DELIMITER /
CREATE TRIGGER WorkersDetectAuthWhitespaceUPD BEFORE UPDATE ON Workers FOR EACH ROW
BEGIN
	IF new.User_login LIKE '% %' OR new.User_pass LIKE '% %' THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Whitespaces in login or password are not allowed';
	END IF;
END /
DELIMITER ;

-- Минимальная заработная плата
-- DROP TRIGGER IF EXISTS WorkerMinSalaryINS;
DELIMITER /
CREATE TRIGGER WorkerMinSalaryINS BEFORE INSERT ON Workers FOR EACH ROW
BEGIN
	IF new.Salary < 5000 THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Salary must be 5000 or more';
	END IF;
END/
DELIMITER ;
-- DROP TRIGGER IF EXISTS WorkerMinSalaryUPD;
DELIMITER /
CREATE TRIGGER WorkerMinSalaryUPD BEFORE UPDATE ON Workers FOR EACH ROW
BEGIN
	IF new.Salary < 5000 THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Salary must be 5000 or more';
	END IF;
END/
DELIMITER ;

-- Проверять должности для заказов и позиций
-- DROP TRIGGER IF EXISTS PositionsCheckWorkerAsAssemblerUPD;
DELIMITER /
CREATE TRIGGER PositionsCheckWorkerAsAssemblerUPD BEFORE UPDATE ON Positions FOR EACH ROW
BEGIN
    DECLARE worker_Post varchar(64);
    SET worker_Post = (SELECT Post FROM Workers WHERE id_Worker = new.Workers_id_Worker);
	IF worker_Post != 'assembler' THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Worker is not a assembler';
	END IF;
END/
DELIMITER ;

-- DROP TRIGGER IF EXISTS PositionsCheckWorkerAsAssemblerINS;
DELIMITER /
CREATE TRIGGER PositionsCheckWorkerAsAssemblerINS BEFORE INSERT ON Positions FOR EACH ROW
BEGIN
    DECLARE worker_Post varchar(64);
    SET worker_Post = (SELECT Post FROM Workers WHERE id_Worker = new.Workers_id_Worker);
	IF worker_Post != 'assembler' THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Worker is not a assembler';
	END IF;
END/
DELIMITER ;

-- DROP TRIGGER IF EXISTS OrdersCheckWorkerAsDriverUPD;
DELIMITER /
CREATE TRIGGER OrdersCheckWorkerAsDriverUPD BEFORE UPDATE ON Orders FOR EACH ROW
BEGIN
    DECLARE worker_Post varchar(64);
    SET worker_Post = (SELECT Post FROM Workers WHERE id_Worker = new.Workers_id_Worker);
	IF worker_Post != 'driver' THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Worker is not a driver';
	END IF;
END/
DELIMITER ;

-- DROP TRIGGER IF EXISTS OrdersCheckWorkerAsDriverINS;
DELIMITER /
CREATE TRIGGER OrdersCheckWorkerAsDriverINS BEFORE INSERT ON Orders FOR EACH ROW
BEGIN
    DECLARE worker_Post varchar(64);
    SET worker_Post = (SELECT Post FROM Workers WHERE id_Worker = new.Workers_id_Worker);
	IF worker_Post != 'driver' THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Worker is not a driver';
	END IF;
END/
DELIMITER ;

-- ----------------------------
-- Служебные записи таблиц
-- ----------------------------
INSERT INTO Pvzs (PVZ, Address, PVZ_Schedule)
VALUES ('ПВЗ не указан', ' ', ' ');
INSERT INTO Vehicles (Vehicle, VIN, GovNumber)
VALUES ('Без ТС', ' ', ' ');
INSERT INTO Workers ( User_login, User_pass, Fullname, Post, Salary, WorkerType, Shift, Vehicles_id_Vehicle )
VALUES ('-', '-', 'Сотрудник не указан', ' ', 5000, 0,  ' ', 1);
-- ----------------------------
-- Заполнение таблиц
-- ----------------------------

-- Таблицы
INSERT INTO Clients (Fullname, PhoneNumber, Email, ClientType)
VALUES
    ( 'Яндульская Марианна Игнатьевна', '+7 (959) 746-44-72', 'marianna59@yandex.ru', 0 ),
    ( 'Янишпольская Алиса Сергеевна', '+7 (930) 732-56-48', 'alisa43@outlook.com', 2 ),
    ( 'Фаммус Егор Степанович', '+7 (958) 271-76-69', 'egor.fammus@outlook.com', 1 ),
    ( 'Низамутдинов Василий Дмитриевич', '+7 (975) 305-75-77', 'vasiliy1987@gmail.com', 2 ),
    ( 'Вазова Инна Севастьяновна', '+7 (993) 648-20-44', 'inna.vazova@mail.ru', 1 );

INSERT INTO Vehicles (Vehicle, VIN, GovNumber)
VALUES
    ( 'Geely Emgrand EC7', 'KS6TV944473456755', 'С866ТК84' ),
    ('Audi A2', 'GX0VX855518853187', 'Е108УВ46'),
    ('Audi A3', 'KR8SF943860695598', 'М708ЕК18'),
    ('BMW X3 M', 'FX0HU884196530198', 'Х960НВ84'),
    ('BMW M5', 'YR9EG774652155467', 'В581ВЕ06');

INSERT INTO Pvzs (PVZ, Address, PVZ_Schedule)
VALUES
    ( 'Главный', 'Россия, Г. Москва, Большой Гнездниковский пер., 3', '5/2' ),
    ( 'Восточный', 'Россия, Г. Москва, Кусковская ул., 17, стр. 1', '5/2' ),
    ( 'Западный', 'Россия, Г. Москва, Союзная ул., 1В, Одинцовоподъезд №2, помещение №102', '5/2' ),
    ( 'Северный', 'Россия, Г. Москва, Окружная ул., 13, Лобня', '7/0' ),
    ( 'Южный', 'Россия, Г. Москва, Севастопольский просп., 51, корп. 2', '5/2' );

INSERT INTO Workers ( User_login, User_pass, Fullname, Post, Salary, WorkerType, Shift, Vehicles_id_Vehicle )
VALUES
    ( 'worker1', '$2y$10$0ZyAySYiysfm0SR.9yfZZucUT7VMT4/ToorGZDaAtIHSyH0dzzlf.', 'Жиглов Данила Денисович', 'admin', 65000, 1, '5/2', 1 ),
    ( 'worker2', '$2y$10$Sy2dmvAuSAHHEUggmqRRnOrKQWymNA/Ii87ARhClCcE0Q2NpsD6NK', 'Новохацкий Константин Никитович', 'driver', 80000, 1, '5/2', 4 ),
    ( 'worker3', '$2y$10$Sy2dmvAuSAHHEUggmqRRnOrKQWymNA/Ii87ARhClCcE0Q2NpsD6NK', 'Райан Томас Гослинг', 'driver', 120000, 1, '6/1', 3 ),
    ( 'worker4', '$2y$10$Sy2dmvAuSAHHEUggmqRRnOrKQWymNA/Ii87ARhClCcE0Q2NpsD6NK', 'Осокина Виктория Прокловна', 'manager', 40000, 2, '5/2', 1 ),
    ( 'worker5', '$2y$10$Sy2dmvAuSAHHEUggmqRRnOrKQWymNA/Ii87ARhClCcE0Q2NpsD6NK', 'Бурда Настасья Всеволодовна', 'manager', 60000, 1, '5/2', 1 ),
    ( 'worker6', '$2y$10$Sy2dmvAuSAHHEUggmqRRnOrKQWymNA/Ii87ARhClCcE0Q2NpsD6NK', 'Акимова Афанасия Петровна', 'assembler', 30000, 1, '3/3', 1 ),
    ( 'worker7', '$2y$10$Sy2dmvAuSAHHEUggmqRRnOrKQWymNA/Ii87ARhClCcE0Q2NpsD6NK', 'Квасников Егор Арсеньевич', 'assembler', 45000, 2, '5/3', 1 );

INSERT INTO Positions ( Position, PositionType, PositionLocation, Workers_id_Worker )
VALUES
    ('Стул', 'Мебель', 'A1B1', 8),
    ('Игрушка Хаги-Ваги', 'Игрушки', 'A1B2', 7),
    ('Средство от кашля', 'Лекарство', 'A2B1', 8),
    ( 'Подушка длинная', 'Постельные принадлежности', 'A4B1', 8),
    ('Вода в бутылях', 'Вода', 'A1B3', 7),
    ('Игрушка Амогус', 'Игрушки', 'A2B4', 7);

INSERT INTO Orders ( Positions_id_Position, Clients_id_Client, Pvzs_id_Pvz, Workers_id_Worker, DeliveryAmount, DeliveryDate, DeliveryStatus )
VALUES
    (4, 3, 5, 4, 500, '20221030', 5),
    (5, 2, 4, 3, 560, '20221014', 4),
    (1, 1, 3, 3, 700, '20221016', 0),
    (2, 5, 2, 3, 300, '20221012', 2),
    (3, 4, 1, 4, 720, '20221031', 4),
    (6, 4, 1, 4, 790, '20221030', 6);