<?php
require_once getFileFromRoot('/_base_classes.php');
class graphController extends baseController {
    public function __construct($ModelClass, $ViewClass, $current_path)
    {
        parent::__construct($ModelClass, $ViewClass, $current_path);
        $this->view->loadHeader();
        $images = $this->model->generateImages();
        $this->view->loadContentWithImages($images);
        $this->view->loadFooter();
    }
}

require_once getFileFromRoot('/graph/_graphModel.php');

class graphView extends baseView
{
    public function loadContentWithImages($images)
    {
        require_once getFileFromRoot($this->current_path);
    }
}
?>