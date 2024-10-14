<?php

class Usuario {

    function insert($username, $email, $password) {
        require_once "../app/db/dbConnection.php";

        $query = "INSERT INTO tUsuarios (username, email, password) VALUES (:username, :email, :password)";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);

        $stmt->execute();
        $pdo = $stmt = null;
    }

    function searchByUsername($username) {
        require_once "../app/db/dbConnection.php";

        $query = "SELECT * FROM tUsuarios WHERE username = :username";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":username", $username);

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo = $stmt = null;

        return $results;
    }
}
?>