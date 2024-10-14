<?php
    class ClienteController extends Controller {
        public function index() {
            $this->redirect($this->siteUrl("home/entrar"));
        }

        public function listar() {
            $data = [];

            $this->validateList($search, $errors);

            if (empty($errors)) {
                try {
                    $data['search'] = $search;

                    $obj = $this->model('Cliente');
                    $data['clientes'] = $obj->list($search);

                } catch (PDOException $e) {
                    die("Erro ao buscar clientes: " . $e->getMessage());
                }
            } else {
                foreach ($errors as $field => $errs) {
                    foreach ($errs as $error) {
                        echo "Erro no campo '$field': $error<br>";
                    }
                }
                die();
            }

            $this->view("structure/header");
            $this->view("cliente/listar", $data);
            $this->view("structure/footer");
        }

        public function detalhes($id = null) {
            $data["urlForm"] = $this->siteUrl("cliente/salvar");
            if ($id != "") {
                $data["urlForm"] = $this->siteUrl("cliente/salvar/$id");
            }
            $this->view("structure/header");
            $this->view("cliente/detalhes", $data);
            $this->view("structure/footer");
        }

        public function salvar() {
            if ($this->postRequest()) {
                $this->validateCliente($cpf_cnpj, $name, $email, $cellphone, $errors);

                if (empty($errors)) {
                    try {
                        $obj = $this->model('Cliente');
                        $obj->insert($cpf_cnpj, $name, $email, $cellphone);

                        $this->redirect($this->siteUrl("cliente/listar"));
                    } catch (PDOException $e) {
                        die("Erro ao registrar cliente: " . $e->getMessage());
                    }
                } else {
                    foreach ($errors as $field => $errs) {
                        foreach ($errs as $error) {
                            echo "Erro no campo '$field': $error<br>";
                        }
                    }
                    die();
                }
            }

            $this->redirect($this->siteUrl("home/registrar"));
        }

        public function validateCliente(&$cpf_cnpj = null, &$name = null, &$email = null, &$cellphone = null, &$errors = []) {
            $fieldsToValidate = [
                "cpf_cnpj" => [
                    "required"     => true,
                    "onlyNumbers"  => true,
                    "minLength"    => 11,
                    "maxLength"    => 14
                ],
                "name" => [
                    "required"     => true,
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "minLength"    => 6,
                    "maxLength"    => 250
                ],
                "email" => [
                    "cleanHtml" => true,
                    "email"     => true,
                    "minLength" => 6,
                    "maxLength" => 250
                ],
                "cellphone" => [
                    "onlyNumbers"  => true,
                    "minLength"    => 13,
                    "maxLength"    => 13
                ]
            ];

            $validationResults = $this->validateFields($fieldsToValidate);

            if ($validationResults['valid']) {
                $cpf_cnpj  = $validationResults['data']['cpf_cnpj'];
                $name      = $validationResults['data']['name'];
                $email     = $validationResults['data']['email'];
                $cellphone = $validationResults['data']['cellphone'];

            } else {
                $errors   = $validationResults['errors'];
            }
        }

        protected function validateList(&$search, &$errors) {
            $fieldsToValidate = [
                "search" => [
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "minLength"    => 1,
                    "maxLength"    => 255
                ]
            ];

            $validationResults = $this->validateFields($fieldsToValidate);

            if ($validationResults['valid']) {
                $search  = $validationResults['data']['search'];
            } else {
                $errors   = $validationResults['errors'];

                $data = $this->processData();
                if (isset($data['validate']) && $data['validate'] == true) {
                    echo json_encode($errors);
                }
            }
        }

        public function removeCustomer($id) {
            try {
                $obj = $this->model('Cliente');
                $obj->removeById($id);
            } catch (PDOException $e) {
                die("Erro ao remover cliente: " . $e->getMessage());
            }
        }
    }
?>