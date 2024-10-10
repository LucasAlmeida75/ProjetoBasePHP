<?php
    class HomeController extends Controller {
        public function index() {
            $this->redirect($this->siteUrl("home/registrar"));
        }
        /* public function index($nome = "") {
            $cliente = $this->model('Cliente');
            $cliente->nome = $nome;

            $data["nome"] = $cliente->nome;
            $this->view("home/index", $data);
        } */

        public function registrar() {
            $this->view("structure/header");
            $this->view("home/registrar");
            $this->view("structure/footer");
        }

        public function salvar() {
            if ($_POST) {
                $username = $this->cleanString($_POST['username']);
                $password = $this->cleanString($_POST['password']);

                if ($this->validateRegister()) {
                    
                }
            }

        }

        protected function validateRegister() {
            $username = $this->cleanString($_POST['username']);
            $password = $this->cleanString($_POST['password']);

            if (strlen($username) < 4)
                return false;

            if (strlen($password) < 6)
                return false;

            return true;
        }
    }
?>