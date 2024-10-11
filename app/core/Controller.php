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

    protected function validateFields($fields, $method = "POST") {
        $validatedData = [];
        $errors = [];

        foreach ($fields as $fieldName => $options) {
            if ($method == "POST")
                $value = $_POST[$fieldName] ?? null;
            else
                $value = $_GET[$fieldName] ?? null;

            if (isset($options['cleanHtml']) && $options['cleanHtml'] === true) {
                $value = strip_tags($value);
            }

            if (isset($options['cleanSpecial']) && $options['cleanSpecial'] === true) {
                $value = preg_replace('/[^a-zA-Z0-9]/', '', $value);
            }

            if (isset($options['toUpper']) && $options['toUpper'] === true) {
                $value = mb_strtoupper($value);
            }

            $validationResult = $this->applyValidation($value, $options);

            if ($validationResult !== true) {
                $errors[$fieldName] = $validationResult;
            } else {
                $validatedData[$fieldName] = $value;
            }
        }

        return [
            'valid' => empty($errors),
            'data' => $validatedData,
            'errors' => $errors
        ];
    }

    protected function applyValidation($value, $options) {
        $errors = [];

        foreach ($options as $option => $rule) {
            switch ($option) {
                case 'string':
                    if (!is_string($value)) {
                        $errors[] = ' deve ser uma string.';
                    }
                    break;

                case 'int':
                    if (!is_int($value) && !ctype_digit($value)) {
                        $errors[] = ' deve ser um número inteiro.';
                    }
                    break;

                case 'float':
                    if (!is_float($value) && !is_numeric($value)) {
                        $errors[] = ' deve ser um número decimal.';
                    }
                    break;

                case 'email':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = ' não é um endereço de email válido.';
                    }
                    break;

                case 'min':
                    if (is_numeric($value) && $value < $rule) {
                        $errors[] = ' deve ser pelo menos ' . $rule . '.';
                    }
                    break;

                case 'max':
                    if (is_numeric($value) && $value > $rule) {
                        $errors[] = ' não pode ser maior que ' . $rule . '.';
                    }
                    break;

                case 'minLength':
                    if (is_string($value) && strlen($value) < $rule) {
                        $errors[] = ' deve ter pelo menos ' . $rule . ' caracteres.';
                    }
                    break;

                case 'maxLength':
                    if (is_string($value) && strlen($value) > $rule) {
                        $errors[] = ' não pode exceder ' . $rule . ' caracteres.';
                    }
                    break;

                case 'cleanHtml':
                case 'cleanSpecial':
                case 'toUpper':
                    break;

                default:
                    $errors[] = 'Regra de validação inválida especificada.';
            }
        }

        return empty($errors) ? true : $errors;
    }

    protected function postRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
            return true;

        return false;
    }

    protected function pre($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
}
?>