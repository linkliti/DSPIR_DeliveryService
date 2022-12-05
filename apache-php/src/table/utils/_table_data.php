<?php
switch (currentFile()) {
  case 'clients.php':
    $table_data = array('id_Client', 'id_Client', 'Fullname', 'PhoneNumber', 'Email', 'ClientType');
    $table_headers_modify = array('', 'ID клиента', 'ФИО', 'Тел Номер', 'Почта', 'Тип');
    $table_headers_show = array('', 'ID', 'ФИО', 'Тел Номер', 'Почта', 'Тип');
    $ignore_first = false;
    break;
  case 'orders.php':
    $table_data = array('id_Order', 'id_Order', 'Positions_id_Position', 'Clients_id_Client', 'Pvzs_id_Pvz', 'Workers_id_Worker', 'DeliveryAmount', 'DeliveryDateTime', 'DeliveryStatus');
    $table_headers_modify = array('', 'ID доставки', 'ID позиции', 'ID клиента', 'ID ПВЗ', 'ID Сборщика', 'Сумма', 'Дата доставки', 'Статус');
    $table_headers_show = array('', 'ID', '>', 'ID, Наим. позиции', '>', 'ID, ФИО Клиента', '>', 'ID, Имя ПВЗ', '>', 'ID, ФИО Водителя', 'Сумма', 'Дата доставки', '>', 'Статус');
    $ignore_first = false;
    break;
  case 'positions.php':
    $table_data = array('id_Position', 'id_Position', 'Position', 'PositionType', 'PositionLocation', 'Workers_id_Worker');
    $table_headers_modify = array('', 'ID позиции', 'Наименование', 'Тип', 'Расположение', 'ID сборщика');
    $table_headers_show = array('', 'ID', 'Наименование', 'Тип', 'Расположение', '>', 'ID, ФИО сборщика');
    $ignore_first = false;
    break;
  case 'pvzs.php':
    $table_data = array('id_Pvz', 'id_Pvz', 'PVZ', 'Address', 'PVZ_Schedule');
    $table_headers_modify = array('', 'ID ПВЗ', 'Наименование', 'Адрес', 'Расписание');
    $table_headers_show = array('', 'ID', 'Наименование', 'Адрес', 'Расписание');
    $ignore_first = true;
    break;
  case 'vehicles.php':
    $table_data = array('id_Vehicle', 'id_Vehicle', 'Vehicle', 'VIN', 'GovNumber');
    $table_headers_modify = array('', 'ID авто', 'ТС', 'Марка', 'Гос Номер');
    $table_headers_show = array('', 'ID', 'ТС', 'Марка', 'Гос Номер');
    $ignore_first = true;
    break;
  case 'workers.php':
    $table_data = array('id_Worker', 'id_Worker', 'User_login', 'User_pass', 'Fullname', 'Post', 'Salary', 'WorkerType', 'Shift', 'Vehicles_id_Vehicle');
    $table_headers_modify = array('', 'ID сотрудника', 'Логин', 'Пароль', 'ФИО', 'Должность', 'Зарплата', 'Тип', 'Смена', 'Статистика', 'Доход', 'ID транспорта');
    $table_headers_show = array('', 'ID', 'Логин', 'ФИО', 'Должность', 'Зарплата', 'Тип', 'Смена', '>', 'ID, Наим. транспорта');
    $ignore_first = true;
    break;
  default:
    $$cont->view->outputStatus(2, 'Unexpected error');
    return;
}
?>