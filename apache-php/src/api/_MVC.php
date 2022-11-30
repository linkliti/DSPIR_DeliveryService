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
    public function getTable($post)
    {
        $query = "CALL get" . $post . "Table();";
        return $this->mysqli->query($query);
    }

}
class apiView extends baseView
{
}
?>