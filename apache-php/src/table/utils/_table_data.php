<?php
function getTableFormData($table)
{
  switch ($table) {
    case 'clients.php':
      $table_data = array('id_Client', 'id_Client', 'Fullname', 'PhoneNumber', 'Email', 'ClientType');
      break;
    case 'orders.php':
      $table_data = array('id_Order', 'id_Order', 'Positions_id_Position', 'Clients_id_Client', 'Pvzs_id_Pvz', 'Workers_id_Worker', 'DeliveryAmount', 'DeliveryDateTime', 'DeliveryStatus');
      break;
    case 'positions.php':
      $table_data = array('id_Position', 'id_Position', 'Position', 'PositionType', 'PositionLocation', 'Workers_id_Worker');
      break;
    case 'pvzs.php':
      $table_data = array('id_Pvz', 'id_Pvz', 'PVZ', 'Address', 'WorkersAmount', 'PVZ_Schedule');
      break;
    case 'vehicles.php':
      $table_data = array('id_Vehicle', 'id_Vehicle', 'Vehicle', 'VIN', 'GovNumber');
      break;
    case 'workers.php':
      $table_data = array('id_Worker', 'id_Worker', 'User_login', 'User_pass', 'Fullname', 'Post', 'Salary', 'WorkerType', 'Shift', 'Statistic', 'Revenue', 'Vehicles_id_Vehicle');
      break;
    default:
      $table_data = false;
      break;
    }
    return $table_data;
}
?>