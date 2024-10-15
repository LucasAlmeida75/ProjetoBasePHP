<?php
    class UsuarioController extends Controller {
        public function index() {
            $this->redirect($this->siteUrl("home/entrar"));
        }

        public function cadastro($nome = "", $sobrenome = "") {
            echo
            "nome: " . $nome . "<br><br>" .
            "sobrenome: " . $sobrenome . "<br><br>" ;exit;
        }

        public function registrar() {
            if ($this->postRequest()) {
                $this->validateRegistrar($username, $email, $password, $errors);

                if (empty($errors)) {

                    try {
                        $obj = $this->model('Usuario');
                        $obj->insert($username, $email, $password);

                        $this->redirect($this->siteUrl("home/entrar"));
                        exit;
                    } catch (PDOException $e) {
                        die("Erro ao registrar usuário: " . $e->getMessage());
                    }
                } else {
                    foreach ($errors as $field => $errs) {
                        foreach ($errs as $error) {
                            echo "Erro no campo '$field': $error<br>";
                        }
                    }
                }

                exit;
            }

            $this->redirect($this->siteUrl("home/registrar"));
        }

        public function entrar() {

            if ($this->postRequest()) {

                $this->validateEntrar($username, $password, $errors);

                if (empty($errors)) {
                    session_start();
                    $_SESSION['loggedIn'] = true;
                    $this->redirect($this->siteUrl("home/home"));
                    exit;
                } else {
                    foreach ($errors as $field => $errs) {
                        foreach ($errs as $error) {
                            echo "Erro no campo '$field': $error<br>";
                        }
                    }
                }
            }

            $this->redirect($this->siteUrl("home/entrar"));
        }

        protected function validateEntrar(&$username, &$password, &$errors) {
            $fieldsToValidate = [
                'username' => [
                    "required"     => true,
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "toUpper"      => true,
                    "minLength"    => 4,
                    "maxLength"    => 50
                ],
                'password' => [
                    "required"  => true,
                    "cleanHtml" => true,
                    "minLength" => 6,
                    "maxLength" => 250
                ]
            ];

            $validationResults = $this->validateFields($fieldsToValidate);

            if ($validationResults['valid']) {
                $username = $validationResults['data']['username'];
                $password = $validationResults['data']['password'];

                $obj = $this->model('Usuario');
                $user = $obj->searchByUsername($username);

                if (!is_array($user))
                    $errors["username"][] = "usuário ou senha incorretos!";

                $passwordVerified = password_verify($password, $user['password']);

                if (!$passwordVerified)
                    $errors["username"][] = "usuário ou senha incorretos!";
            } else {
                $errors   = $validationResults['errors'];
            }
        }

        protected function validateRegistrar(&$username, &$email, &$password, &$errors) {
            $fieldsToValidate = [
                'username' => [
                    "required"     => true,
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "toUpper"      => true,
                    "minLength"    => 4,
                    "maxLength"    => 50
                ],
                'password' => [
                    "required"  => true,
                    "cleanHtml" => true,
                    "minLength" => 6,
                    "maxLength" => 250
                ],
                'email' => [
                    "required"  => true,
                    "cleanHtml" => true,
                    "email"     => true,
                    "minLength" => 6,
                    "maxLength" => 250
                ]
            ];

            $validationResults = $this->validateFields($fieldsToValidate);

            if ($validationResults['valid']) {
                $username = $validationResults['data']['username'];
                $email    = $validationResults['data']['email'];
                $password = password_hash($validationResults['data']['password'], PASSWORD_DEFAULT);

                $obj = $this->model('Usuario');
                $user = $obj->searchByUsername($username);
                if (count($user) > 0)
                    $errors["username"][] = "usuário já cadastrado!";

            } else {
                $errors   = $validationResults['errors'];
            }
        }
    }
?>