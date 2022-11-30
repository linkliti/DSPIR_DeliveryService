<?php
require_once getFileFromRoot('/_base_classes.php');
class apiController extends baseController
{
    public function __construct($ModelClass, $ViewClass, $current_path)
    {
        parent::__construct($ModelClass, $ViewClass, $current_path);
        $json = $this->getPost();
        $file = currentFile();
        require_once getFileFromRoot('/api/' . $file);
    }
    protected function getPost()
    {
        $data = file_get_contents('php://input');
        $jsondata = json_decode($data, true);
        return $jsondata;
    }
}
class apiModel extends baseModel
{
    public function __construct() {
        parent::__construct();
    }
    public function getOrderStatus($order_id)
    {
        $query = "CALL getOrderStatus(" . $order_id .");";
        $result = $this->mysqli->query($query);
        $result = $result->fetch_row();
        if ($result == null) {
            return array(-1, 'Заказ не найден');
        }
        return $result;
    }
    public function getTable($table)
    {
        $query = "CALL get" . $table . "Table();";
        return $this->mysqli->query($query);
    }

    public function checkIDinTable($table, $id)
    {
        $table = ucfirst($table);
        $id_name = substr($table, 0, -1);
        $query = "SELECT id_" . $id_name . " FROM " . $table . " WHERE id_" . $id_name . " = " . $id . ";";
        $result = $this->mysqli->query($query);
        return $result->fetch_row();
    }

    public function deleteFromTable($table, $id) {
        $table = ucfirst($table);
        $id_name = substr($table, 0, -1);
        $query = "DELETE FROM " . $table . " WHERE id_". $id_name . " = " . $id . ";";
        $this->mysqli->query($query);
        return $id;
    }

}
class apiView extends baseView
{
}
?>