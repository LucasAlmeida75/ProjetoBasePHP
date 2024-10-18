<?php
    class AuthController extends Controller {
        public function index() {
            $this->redirect($this->siteUrl("auth/entrar"));
        }

        public function entrar() {
            $data['sidebarOff'] = true;
            $this->view("structure/header", $data);
            $this->view("auth/entrar");
            $this->view("structure/footer", $data);
        }

        public function registrar() {
            $data['sidebarOff'] = true;
            $this->view("structure/header", $data);
            $this->view("auth/registrar");
            $this->view("structure/footer", $data);
        }

        public function signup() {
            if ($this->postRequest()) {
                $this->validateSignup($username, $email, $password, $errors);

                if (empty($errors)) {

                    try {
                        $obj = $this->model('Usuario');
                        $obj->insert($username, $email, $password);

                        $this->redirect($this->siteUrl("auth/entrar"));
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

            $this->redirect($this->siteUrl("auth/registrar"));
        }

        public function signin() {

            if ($this->postRequest()) {

                $this->validateSignin($username, $password, $errors);

                if (empty($errors)) {
                    session_start();
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['username'] = $username;
                    $this->redirect($this->siteUrl("home/home"));
                    exit;
                } else {
                    $this->showErrors($errors);
                }
            }

            $this->redirect($this->siteUrl("auth/entrar"));
        }

        public function signout() {
            session_destroy();
            $this->redirect($this->siteUrl("auth/entrar"));
        }

        protected function validateSignin(&$username, &$password, &$errors) {
            $fieldsToValidate = [
                'username' => [
                    "fieldLabel"   => "Nome de Usuário",
                    "required"     => true,
                    "cleanHtml"    => true,
                    "cleanSpecial" => true,
                    "toUpper"      => true,
                    "maxLength"    => 50
                ],
                'password' => [
                    "fieldLabel" => "Senha",
                    "required"   => true,
                    "cleanHtml"  => true,
                    "maxLength"  => 250
                ]
            ];

            $validationResults = $this->validateFields($fieldsToValidate);

            if ($validationResults['valid']) {
                $username = $validationResults['data']['username'];
                $password = $validationResults['data']['password'];

                $obj = $this->model('Usuario');
                $user = $obj->searchByUsername($username)["result"];

                if (!is_array($user)) {
                    $errors["Entrar"][] = "usuário ou senha incorretos!";
                    return;
                }

                $passwordVerified = password_verify($password, $user['password']);

                if (!$passwordVerified)
                    $errors["Entrar"][] = "usuário ou senha incorretos!";

                return;
            } else {
                $errors   = $validationResults['errors'];
            }
        }

        protected function validateSignup(&$username, &$email, &$password, &$errors) {
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