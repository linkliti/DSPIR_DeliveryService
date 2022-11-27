<?php
require_once getFileFromRoot('/_base_classes.php');
class tableController extends baseController
{
    public function __construct($ModelClass, $ViewClass, $current_path)
    {
        parent::__construct($ModelClass, $ViewClass, $current_path);
        $this->view->loadHeader();
        $file = (explode('/', $_SERVER['REQUEST_URI']))[2];
        $post = explode('.', $file)[0];
        $this->view->loadTable($this->model->getTable($post));
        $this->view->loadFooter();
    }
}
class tableModel extends baseModel
{
    public function getTable($post)
    {
        $query = "CALL get" . $post . "Table();";
        return $this->mysqli->query($query);
    }
}
class tableView extends baseView
{
    public function loadTable($table)
    {
        require_once getFileFromRoot($this->current_path);
    }
}
?>