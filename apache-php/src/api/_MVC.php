<?php
require_once getFileFromRoot('/_base_classes.php');
class apiController extends baseController
{
    protected $postdata;
    public function __construct($ModelClass, $ViewClass, $current_path)
    {
        parent::__construct($ModelClass, $ViewClass, $current_path);
        $this->postdata = $this->getPost();
        $file = (explode('/', $_SERVER['REQUEST_URI']))[2];
        switch ($file) {
            case 'api.php': {
                    $this->view->outputPostJson(json_encode($this->postdata));
                    break;
                }
            case 'settings.php': {
                    $theme = $_SESSION['theme'] ?? false;
                    $_SESSION['theme'] = !$theme;
                }
            default: {
                    echo 'ERROR';
                }
        }
    }
    protected function getPost()
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        return $data;
    }
}
class apiModel extends baseModel
{
}
class apiView extends baseView
{
    public function outputPostJson($json)
    {
        require_once getFileFromRoot($this->current_path);
    }
}
?>