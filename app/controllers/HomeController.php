<?php
    class HomeController extends Controller {
        public function index() {
            $this->redirect($this->siteUrl("home/entrar"));
        }

        public function entrar() {
            $data['sidebarOff'] = true;
            $this->view("structure/header", $data);
            $this->view("home/entrar");
            $this->view("structure/footer", $data);
        }

        public function registrar() {
            $data['sidebarOff'] = true;
            $this->view("structure/header", $data);
            $this->view("home/registrar");
            $this->view("structure/footer", $data);
        }

        public function home() {
            $this->view("structure/header");
            $this->view("home/home");
            $this->view("structure/footer");
        }
    }
?>