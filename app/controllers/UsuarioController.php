<?php
    class UsuarioController extends Controller {
        public function index() {
            $this->redirect($this->siteUrl("auth/entrar"));
        }

        public function cadastro($nome = "", $sobrenome = "") {
            echo
            "nome: " . $nome . "<br><br>" .
            "sobrenome: " . $sobrenome . "<br><br>" ;exit;
        }
    }
?>