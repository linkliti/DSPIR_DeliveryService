<?php
class baseController
{
    protected $model;
    protected $current_path;
    protected $view;
    public function isAlive()
    {
        echo 'Controller alive';
    }
    public function __construct($ModelClass, $ViewClass, $current_path)
    {
        $this->current_path = $current_path;
        $this->model = new $ModelClass();
        $this->view = new $ViewClass($current_path);
        $this->chores();
    }
    protected function chores() {
        # Fill empty session data
        $data = array('theme');
        foreach ($data as $entry) {
            if (
                !isset($_SESSION[$entry])
            ) {
                $_SESSION[$entry] = 0;
            }
        }
    }
}

class baseModel
{
    protected $mysqli;
    public function __construct()
    {
        $this->mysqli = openmysqli();
    }
    public function isAlive()
    {
        echo 'Model alive';
    }
}
class baseView
{
    protected $current_path;
    protected $data;
    public function isAlive()
    {
        echo 'View alive';
    }
    public function __construct($current_path)
    {
        $this->current_path = $current_path;
    }
    public function loadHeader()
    {
        require_once getFileFromRoot('/_templates/_html_header.php');
        require_once getFileFromRoot('/_templates/_page_header.php');
    }

    public function loadContent()
    {
        require_once getFileFromRoot($this->current_path);
    }
    public function loadFooter()
    {
        require_once getFileFromRoot('/_templates/_page_footer.php');
    }
    public function outputStatus($status, $message, $result='')
    {
        if (($result != '')) {
            echo '{"status": ' . $status . ', "result": "' . $result . '", "message": "' . $message . '"}';
        }
        else {
            echo '{"status": ' . $status . ', "message": "' . $message . '"}';
        }
    }
}
?>