<?php

require_once "../app/db/dbConnection.php";

class Usuario {
    private $pdo;

    function __construct() {
        $this->pdo = Database::getInstance();
    }

    function insert($username, $email, $password) {
        $query = "INSERT INTO tUsuarios (username, email, password) VALUES (:username, :email, :password)";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);

        $stmt->execute();
        $pdo = $stmt = null;
    }

    function searchByUsername($username) {
        $query = "SELECT * FROM tUsuarios WHERE username = :username";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":username", $username);

        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $pdo = $stmt = null;

        return $results;
    }
}
?>