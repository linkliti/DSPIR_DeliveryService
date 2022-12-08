<?php
require_once getFileFromRoot('/_base_classes.php');
class pdfController extends baseController
{
    public function __construct($ModelClass, $ViewClass, $current_path)
    {
        parent::__construct($ModelClass, $ViewClass, $current_path);
        $this->view->loadHeader();
        // Body
        switch (currentFile()) {
            case 'upload.php':
                $result = $this->model->uploadPDF($_FILES["userfile"]);
                $this->view->loadContentWithResult($result);
                break;
            case 'showPDF.php':
                $files = $this->model->getPDFfiles();
                $this->view->loadContentWithFiles($files);
            default:
                $this->view->loadContent();
        }
        $this->view->loadFooter();
    }
}
class pdfModel extends baseModel
{
    public function uploadPDF($pdf)
    {
        # Целевая папка
        $target_dir = getFileFromRoot('/userContent/files/');
        # Файл сохранения
        $target_file = $target_dir . basename($pdf["name"]);
        # Флаг проверки
        $uploadOk = 1;
        # Формат
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($pdf["size"] == 0) {
            $uploadOk = 0;
            $failmessage = "Файл не выбран или пустой";
        }
        # Файл существует
        else if (file_exists($target_file)) {
            $uploadOk = 0;
            $failmessage = "Такой файл уже существует";
        }
        # Не PDF
        else if ($fileType != "pdf") {
            $uploadOk = 0;
            $failmessage = "Только PDF файлы доступны к загрузке";
        }
        # Проверки пройдены
        if ($uploadOk == 1) {
            if (move_uploaded_file($pdf['tmp_name'], $target_file)) {
                return array(0, "Файл " . htmlspecialchars(basename($_FILES["userfile"]["name"])) . " был успешно загружен.");
            } else {
                return array(2, "Ошибка загрузки файла");
            }
        }
        return array(1, $failmessage);
    }

    public function getPDFfiles()
    {
        $scanned_directory = array_diff(scandir(getFileFromRoot('/userContent/files')), array('..', '.'));
        if (count($scanned_directory) > 0) {
            return $scanned_directory;
        }
    }
}
class pdfView extends baseView
{
    protected function friendlyErrorStatus($msg) {
        return '<span class="fw-bold text-danger">Ошибка: </span> ' . $msg;
    }
    public function loadContentWithResult($result)
    {
        if ($result[0] != 0) $result[1] = $this->friendlyErrorStatus($result[1]);
        require_once getFileFromRoot($this->current_path);
    }
    public function loadContentWithFiles($files)
    {
        require_once getFileFromRoot($this->current_path);
    }
}
?>