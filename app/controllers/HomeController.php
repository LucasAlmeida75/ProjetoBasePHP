<?php
    class HomeController extends Controller {
        public function index() {
            $this->redirect($this->siteUrl("home/signin"));
        }
        /* public function index($nome = "") {
            $cliente = $this->model('Cliente');
            $cliente->nome = $nome;

            $data["nome"] = $cliente->nome;
            $this->view("home/index", $data);
        } */

        public function signin() {
            $this->view("structure/header");
            $this->view("home/signin");
            $this->view("structure/footer");
        }

        public function signup() {
            $this->view("structure/header");
            $this->view("home/signup");
            $this->view("structure/footer");
        }

        public function home() {
            $this->view("structure/header");
            $this->view("structure/sidebar");
            $this->view("home/home");
            $this->view("structure/footer");
        }
    }
?>