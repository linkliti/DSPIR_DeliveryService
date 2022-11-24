<?php
class baseController
{
    protected $model;
    protected $view;
    public function isAlive()
    {
        echo 'Controller alive';
    }
    public function __construct($ModelClass, $ViewClass)
    {
        $this->model = new $ModelClass;
        $this->view = new $ViewClass;
        $this->view->isAlive();
        $this->model->isAlive();
    }
}

class baseModel
{
    public function __construct()
    {
    }
    public function isAlive()
    {
        echo 'Model alive';
    }
}
class baseView
{
    public function isAlive()
    {
        echo 'View alive';
    }
    public function __construct()
    {
    }
}
?>