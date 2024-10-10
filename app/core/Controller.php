<?php
class Controller {

    protected function model($model) {
        require_once "../app/models/$model.php";
        return new $model();
    }

    protected function view($view, $data = []) {
        require_once "../app/views/$view.php";
    }

    protected function redirect($url, $permanent = false) {
        if (headers_sent() === false) {
            header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
        }

        exit();
    }

    protected function siteUrl($location) {

        $http = (empty($_SERVER['HTTPS']) ? 'http' : 'https');

        $url =  "$http://{$_SERVER["HTTP_HOST"]}/ProjetoBasePHP/public/";

        return $url . $location;
    }

    protected function cleanString($string) {
        return htmlspecialchars($string);
    }
}
?>