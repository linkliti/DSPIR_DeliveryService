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
    protected $current_path;
    protected $data;
    public function isAlive()
    {
        echo 'View alive';
    }
    public function __construct($current_path, $data = null)
    {
        $this->current_path = $current_path;
        if (isset($data)) {
            $this->data = $data;
        }
    }
    public function loadHeader()
    {
        require_once getFileFromRoot('/templates/html_header.php');
        require_once getFileFromRoot('/templates/page_header.php');
    }

    public function loadContent()
    {
        require_once getFileFromRoot($this->current_path);
    }
    public function loadFooter()
    {
        require_once getFileFromRoot('/templates/page_footer.php');
    }
}
?>