<?php
    class ClienteController extends Controller {
        public function index() {
            $this->redirect($this->siteUrl("auth/entrar"));
        }

        public function listar() {
            $data = [];

            $this->validateList($search, $errors);

            if (empty($errors)) {
                try {
                    $data['search'] = $search;

                    $obj = $this->model('Cliente');
                    $data['clientes'] = $obj->list($search)["result"];

                } catch (PDOException $e) {
                    die("Erro ao buscar clientes: " . $e->getMessage());
                }
            } else {
                $this->showErrors($errors);
            }

            $this->view("structure/header");
            $this->view("cliente/listar", $data);
            $this->view("structure/footer");
        }

        public function detalhes($id = null) {
            $data["urlForm"] = $this->siteUrl("cliente/salvar");
            if ($id != "") {
                $data["urlForm"] = $this->siteUrl("cliente/salvar/$id");

                try {
                    $obj = $this->model('Cliente');
                    $data['cliente'] = $obj->searchById($id)["result"];

                    if (!is_array($data["cliente"]))
                        $this->redirect($this->siteUrl("cliente/listar"));

                } catch (PDOException $e) {
                    die("Erro ao buscar clientes: " . $e->getMessage());
                }
            }
            $this->view("structure/header");
            $this->view("cliente/detalhes", $data);
            $this->view("structure/footer");
        }

        public function salvar($id = null) {
            if ($this->postRequest()) {
                $this->validateCliente($cpf_cnpj, $name, $email, $cellphone, $errors);

                if (empty($errors)) {
                    try {
                        $obj = $this->model('Cliente');
                        if ($id == null) {
                            $obj->insert($cpf_cnpj, $name, $email, $cellphone);
                        } else {
                            $cliente = $obj->searchById($id);
                            if (is_array($cliente))
                                $obj->updateById($id, $cpf_cnpj, $name, $email, $cellphone);
                        }

                        $this->alertSuccess();
                        $this->redirect($this->siteUrl("cliente/listar"));
                    } catch (PDOException $e) {
                        die("Erro ao atualizar cliente: " . $e->getMessage());
                    }
                } else {
                    $this->showErrors($errors);
                    $this->redirect($this->siteUrl("cliente/detalhes"));
                }
            }

            $this->redirect($this->siteUrl("auth/entrar"));
        }

        public function validateCliente(&$cpf_cnpj = null, &$name = null, &$email = null, &$cellphone = null, &$errors = []) {
            $fieldsToValidate = [
                "cpf_cnpj" => [
                    "fieldLabel"  => "CPF/CNPJ",
                    "required"    => true,
                    "onlyNumbers" => true,
                    "minLength"   => 11,
                    "maxLength"   => 14
                ],
                "name" => [
                    "fieldLabel"   => "Nome do cliente",
                    "required"     => true,
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "toUpper"      => true,
                    "minLength"    => 6,
                    "maxLength"    => 250
                ],
                "email" => [
                    "fieldLabel" => "E-mail",
                    "cleanHtml"  => true,
                    "email"      => true,
                    "minLength"  => 6,
                    "maxLength"  => 250
                ],
                "cellphone" => [
                    "fieldLabel"  => "Celular",
                    "onlyNumbers" => true,
                    "minLength"   => 13,
                    "maxLength"   => 13
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

                $data = $this->processData();
                if (isset($data['validate']) && $data['validate'] == true) {
                    echo json_encode($errors);
                }
            }
        }

        protected function validateList(&$search, &$errors) {
            $fieldsToValidate = [
                "search" => [
                    "fieldLabel"   => "Pesquisar",
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "toUpper"      => true,
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