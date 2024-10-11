<?php
    class UserController extends Controller {
        public function index() {
            $this->redirect($this->siteUrl("home/signup"));
        }

        public function cadastro($nome = "", $sobrenome = "") {
            echo
            "nome: " . $nome . "<br><br>" .
            "sobrenome: " . $sobrenome . "<br><br>" ;exit;
        }

        public function signup() {
            if ($this->postRequest()) {
                $this->validateSignup($username, $email, $password, $errors);

                if (empty($errors)) {

                    try {
                        $obj = $this->model('User');
                        $obj->insert($username, $email, $password);

                        $this->redirect($this->siteUrl("home/signup"));
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

                return;
            }

            $this->redirect($this->siteUrl("home/signup"));
        }

        public function signin() {
            if ($this->postRequest()) {
                $this->validateSignin($username, $password, $errors);

                if (empty($errors)) {

                    try {
                        $obj = $this->model('User');
                        $obj->insert($username, $password);

                        $this->redirect($this->siteUrl("home/home"));
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
            }

            $this->redirect($this->siteUrl("home/signin"));
        }

        protected function validateSignin(&$username, &$password, &$errors) {
            $fieldsToValidate = [
                'username' => [
                    "string"       => true,
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "toUpper"      => true,
                    "minLength"    => 4,
                    "maxLength"    => 50
                ],
                'password' => [
                    "string"    => true,
                    "cleanHtml" => true,
                    "minLength" => 6,
                    "maxLength" => 250
                ]
            ];

            $validationResults = $this->validateFields($fieldsToValidate);

            if ($validationResults['valid']) {
                $username = $validationResults['data']['username'];
                $password = $validationResults['data']['password'];

                $obj = $this->model('User');
                $user = $obj->searchByUsername($username);
                if (count($user) == 0)
                    $errors["username"][] = "usuário ou senha incorretos!";

                $passwordVerified = password_verify($password, $user['password']);

                if (!$passwordVerified)
                    $errors["username"][] = "usuário ou senha incorretos!";
            } else {
                $errors   = $validationResults['errors'];
            }
        }

        protected function validateSignup(&$username, &$email, &$password, &$errors) {
            $fieldsToValidate = [
                'username' => [
                    "string"       => true,
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "toUpper"      => true,
                    "minLength"    => 4,
                    "maxLength"    => 50
                ],
                'password' => [
                    "string"    => true,
                    "cleanHtml" => true,
                    "minLength" => 6,
                    "maxLength" => 250
                ],
                'email' => [
                    "string"    => true,
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

                $obj = $this->model('User');
                $user = $obj->searchByUsername($username);
                if (count($user) > 0)
                    $errors["username"][] = "usuário já cadastrado!";

            } else {
                $errors   = $validationResults['errors'];
            }
        }
    }
?>