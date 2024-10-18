<?php
require_once "../app/db/dbConnection.php";

class Cliente {
    private $db;

    function __construct() {
        $this->db = Database::getInstance();
    }

    function insert($cpf_cnpj, $name, $email, $cellphone) {
        $query = "INSERT INTO tClientes (cpf_cnpj, name, email, cellphone)
                  VALUES (:cpf_cnpj, :name, :email, :cellphone)";

        $params = [
            ':cpf_cnpj' => $cpf_cnpj,
            ':name'     => $name,
            ':email'    => $email,
            ':cellphone'=> $cellphone
        ];


        $this->db->executeQuery($query, $params);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }

    function searchById($id) {
        $query = "SELECT * FROM tClientes WHERE id = :id";

        $params = [':id' => $id];

        $stmt = $this->db->executeQuery($query, $params);
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return [
            'lastQuery' => $lastQuery,
            'result'    => $results
        ];
    }

    function removeById($id) {
        $query = "UPDATE tClientes SET inactivated_at = CURRENT_TIMESTAMP WHERE id = :id AND inactivated_at IS NULL";

        $params = [':id' => $id];

        $this->db->executeQuery($query, $params);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }

    function updateById($id, $cpf_cnpj, $name, $email, $cellphone) {
        $query = "UPDATE tClientes SET cpf_cnpj = :cpf_cnpj, name = :name, email = :email, cellphone = :cellphone 
                  WHERE id = :id AND inactivated_at IS NULL";

        $params = [
            ':id'       => $id,
            ':cpf_cnpj' => $cpf_cnpj,
            ':name'     => $name,
            ':email'    => $email,
            ':cellphone'=> $cellphone
        ];

        $this->db->executeQuery($query, $params);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return ['lastQuery' => $lastQuery];
    }

    function list($name = null) {
        $query = "SELECT * FROM tClientes WHERE inactivated_at IS NULL";
        $params = [];

        if ($name !== null) {
            $search = "%" . $name . "%";
            $query .= " AND name LIKE :name";
            $params[':name'] = $search; 
        }

        $stmt = $this->db->executeQuery($query, $params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lastQuery = $this->db->getQueryWithParams($query, $params);

        return [
            'lastQuery' => $lastQuery,
            'result'    => $results
        ];
    }
}
?>