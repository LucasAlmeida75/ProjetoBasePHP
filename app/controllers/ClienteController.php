<?php
    class ClienteController extends Controller {
        public function index() {
            echo "oi";
        }

        public function cadastro($nome = "", $sobrenome = "") {
            echo
            "nome: " . $nome . "<br><br>" .
            "sobrenome: " . $sobrenome . "<br><br>" ;exit;
        }
    }
?>