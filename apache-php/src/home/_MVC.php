<?php
require_once getFileFromRoot('/_base_classes.php');
class homeController extends baseController {
    public function __construct($ModelClass, $ViewClass, $current_path)
    {
        parent::__construct($ModelClass, $ViewClass, $current_path);
        $this->view->loadHeader();
        $this->view->loadContent();
        $this->view->loadFooter();
    }
}
class homeModel extends baseModel
{
}
class homeView extends baseView
{
}
?>