<?php

require_once "../app/db/dbConnection.php";

class Usuario {
    private $db; // Alterado de $pdo para $db

    function __construct() {
        $this->db = Database::getInstance(); // A instância do Database
    }

    function insert($username, $email, $password) {
        $query = "INSERT INTO tUsuarios (username, email, password) VALUES (:username, :email, :password)";

        $params = [
            ':username' => $username,
            ':email'    => $email,
            ':password' => $password
        ];

        $this->db->executeQuery($query, $params);
        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }

    function searchByUsername($username) {
        $query = "SELECT * FROM tUsuarios WHERE username = :username";

        $params = [ ':username' => $username];

        $stmt = $this->db->executeQuery($query, $params);

        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        $lastQuery = $this->db->getQueryWithParams($query, $params);
        return [
            'lastQuery' => $lastQuery,
            'result'    => $results
        ];
    }
}
?>