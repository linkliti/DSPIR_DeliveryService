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
('Митрофанов Илья Русланович', '79861453369', 'fermentum@outlook.com', 1),
('Михайлова Маргарита Матвеевна', '79934024165', 'aliquet.molestie@google.ca', 2),
('Орлов Кирилл Кириллович', '79416781249', 'commodo.at@yahoo.ru', 2),
('Петров Даниил Артемьевич', '79013171117', 'fermentum.convallis@google.ru', 1),
('Плотникова Кира Данииловна', '79105612441', 'integer.mollis.integer@google.ca', 0),
('Попов Адам Романович', '79102076845', 'ut@aol.edu', 1),
('Серова Елизавета Кирилловна', '79925671686', 'fusce.aliquet.magna@outlook.net', 0),
('Смирнов Фёдор Михайлович', '79620159244', 'bibendum.ullamcorper@google.net', 1),
('Степанов Иван Степанович', '79249530118', 'proin@outlook.net', 1),
('Федотова Ульяна Кирилловна', '79157966217', 'duis.elementum.dui@outlook.ca', 1),
('Фирсова Ева Матвеевна', '79217913034', 'venenatis@google.ca', 1),
('Чистякова Алина Данииловна', '79036021175', 'vivamus.rhoncus.donec@hotmail.org', 1),
('Шестакова Виктория Васильевна', '79126869361', 'phasellus.at.augue@icloud.ca', 1);

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
( 'Западный', 'Россия, Г. Москва, Союзная ул., 1В, Одинцовоподъезд №2, помещение №102','5/2' ),
( 'Северный', 'Россия, Г. Москва, Окружная ул., 13, Лобня', '7/0' ),
( 'Южный', 'Россия, Г. Москва, Севастопольский просп., 51, корп. 2', '5/2' );

INSERT INTO Workers ( User_login, User_pass, Fullname, Post, Salary, WorkerType, Shift, Vehicles_id_Vehicle )
VALUES
( 'worker2', '$2y$10$Tz2JvKX.FZZqSm9BJbiqI.HkMz4mEkOubkMLTfzSmmby2CUXucXE6', 'Васильев Леонид Ярославович', 'admin', 65000, 1, '5/2', 1 ),
( 'worker3', '$2y$10$.MrCZTIKZO62CO3tz0PmH.T1UP97LcdTdi6NDWI.HaIqMXN.iUhu.', 'Егоров Дмитрий Михайлович', 'driver', 80000, 1, '5/2', 4 ),
( 'worker4', '$2y$10$/wahnQ9dn.OBOsigXNkAdudnghzy1N6Sgt5FCn32.4OMo0ru0x.z6', 'Климова Варвара Георгиевна', 'driver', 120000, 0, '6/1', 3 ),
( 'worker5', '$2y$10$e8qbBtEL7j2u5ADnFNY6ce2NosYpFaVjh6kU/Rlu1liX8aLLAF9Xi', 'Кондрашов Борис Антонович', 'manager', 40000, 2, '5/2', 1 ),
( 'worker6', '$2y$10$BXwXHmkmjXZqr7VUxxVnUu/X2mJW5dYvVqpque7uiJQ6ALFK/fKs6', 'Малышева София Марковна', 'manager', 60000, 1, '5/2', 1 ),
( 'worker7', '$2y$10$VqU1v0GhBXPYCQ4jrrl73uE47LpmwrpYMAw2kKYiY5QDEIpRkNNRG', 'Мальцев Михаил Ярославович', 'assembler', 30000, 1, '3/3', 1 ),
( 'worker8', '$2y$10$2RzgpwYffKrCVjZ/aeav6ugOOrSaHlXh.0EciQQwVl6CnZRgBG5MK', 'Мальцева Варвара Александровна', 'assembler', 45000, 2, '5/3', 1 ),
( 'worker9', '$2y$10$dYqpiGnJ8wPElVW6Gx8cD.2gIrd0.zQd0OaeZPnjOumiNTKcd5QTC', 'Олейникова Анастасия Викторовна', 'admin', 65000, 1, '5/2', 1 );

INSERT INTO Positions ( Position, PositionType, PositionLocation, Workers_id_Worker )
VALUES
('Стул', 'Мебель', 'D3K5', 7),
('Гребень', 'Хозяйственное', 'P9O4', 8),
('Тетива', 'Развлечение', 'S9B2', 7),
('Розетка', 'Электрика', 'A3G4', 7),
('Журнал', 'Развлечение', 'B2L5', 7),
('Веер', 'Хозяйственное', 'C0M0', 8),
('Компакт-диск с игрой', 'Развлечение', 'U6Y8', 8),
('Сандалии', 'Обувь', 'V9N6', 8),
('Держатель для благовоний', 'Хозяйственное', 'N1Z6', 8),
('Бандана', 'Одежда', 'S7Q6', 7),
('Нож для стейка', 'Кухонное', 'S0R2', 8),
('Колода карт', 'Развлечение', 'T8N0', 8),
('Ковш', 'Кухонное', 'Y3E2', 7),
('Носорог', 'Игрушка', 'I8W2', 7),
('Резиновая утка', 'Развлечение', 'J7D7', 7),
('Гетры', 'Одежда', 'G3C9', 8),
('Упаковка блесток', 'Развлечение', 'T9M6', 7),
('Ластик', 'Хозяйственное', 'A9F3', 7),
('Фонарь', 'Инструмент', 'H4N0', 8),
('Палка', 'Инструмент', 'F6V5', 8),
('Несколько батарей', 'Электрика', 'R5R3', 7),
('Конфетная обертка', 'Кухонное', 'I8P4', 7),
('Игрушечная лодка', 'Игрушка', 'R2E0', 8),
('Вода', 'Еда', 'O0C9', 7),
('Солома', 'Еда', 'G9W2', 7),
('Очки', 'Одежда', 'Q5V9', 8),
('Чековая книжка', 'Хозяйственное', 'P1W3', 8),
('Ручка', 'Хозяйственное', 'P1E4', 8),
('Коробка мороженого', 'Еда', 'W2G4', 8),
('Телевизор', 'Электрика', 'G7O6', 7),
('Наперсток', 'Хозяйственное', 'Z7Y7', 7),
('Отвертка', 'Инструмент', 'A4E3', 8),
('Рыболовный крючок', 'Инструмент', 'I2K5', 8),
('Удлинитель', 'Электрика', 'Z7N1', 7),
('Молоко', 'Еда', 'U5I4', 7),
('Набор домино', 'Игрушка', 'L9F6', 8),
('Кит', 'Игрушка', 'T7G8', 7),
('Желудь', 'Еда', 'I6S6', 7),
('Маленький мешочек', 'Хозяйственное', 'K1G4', 7),
('Камень', 'Инструмент', 'M6W5', 8),
('Кнопка', 'Хозяйственное', 'D3J6', 7),
('Колокол', 'Хозяйственное', 'A8Z8', 7),
('Радио', 'Электрика', 'V9T2', 7),
('Фольга', 'Кухонное', 'B0Z3', 8),
('Кухонный нож', 'Кухонное', 'K8U4', 7),
('Детская книга', 'Развлечение', 'U1S4', 8),
('Резинка', 'Развлечение', 'T7Y2', 7),
('Книга анекдотов', 'Развлечение', 'E7O6', 7),
('Одеяло', 'Мебель', 'L9E6', 7),
('Бананы', 'Еда', 'E9I0', 7);

INSERT INTO Orders ( Positions_id_Position, Clients_id_Client, Pvzs_id_Pvz, Workers_id_Worker, DeliveryAmount, DeliveryDate, DeliveryStatus )
VALUES
(46, 8, 4, 3, 2400, '20230304', 4),
(25, 1, 3, 3, 700, '20230604', 4),
(48, 8, 4, 3, 600, '20231110', 2),
(7, 1, 5, 4, 300, '20230522', 0),
(3, 7, 2, 3, 1000, '20230226', 3),
(22, 2, 2, 3, 2200, '20230626', 1),
(40, 11, 2, 3, 1900, '20231011', 5),
(8, 4, 4, 4, 2400, '20230527', 6),
(24, 6, 5, 3, 2100, '20230823', 6),
(5, 11, 2, 4, 900, '20230901', 4),
(38, 6, 5, 4, 900, '20230715', 0),
(43, 10, 5, 4, 2100, '20231204', 3),
(19, 3, 3, 4, 1000, '20230102', 5),
(9, 12, 4, 3, 2400, '20230830', 1),
(36, 12, 5, 4, 1600, '20230927', 0),
(15, 9, 3, 4, 1300, '20230301', 6),
(23, 3, 2, 4, 2200, '20231020', 6),
(29, 10, 6, 4, 2300, '20230510', 0),
(2, 2, 2, 4, 2400, '20230818', 5),
(21, 10, 3, 4, 2400, '20230926', 0),
(45, 9, 6, 3, 1100, '20230702', 2),
(18, 2, 5, 3, 2500, '20231128', 1),
(17, 6, 5, 4, 2400, '20230314', 2),
(27, 2, 6, 3, 1900, '20230228', 6),
(10, 8, 5, 3, 900, '20230404', 4),
(39, 8, 6, 4, 1000, '20230403', 6),
(14, 1, 2, 4, 1800, '20230530', 2),
(6, 12, 3, 4, 700, '20230225', 0),
(16, 2, 3, 3, 2400, '20230722', 1),
(30, 1, 3, 3, 500, '20231115', 2);