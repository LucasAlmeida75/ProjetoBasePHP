<?php
require_once "../app/db/dbConnection.php";

class Cliente {
    private $pdo;

    function __construct() {
        $this->pdo = Database::getInstance();
    }

    function insert($cpf_cnpj, $name, $email, $cellphone) {
        $query = "INSERT INTO
                  tClientes (cpf_cnpj, name, email, cellphone)
                  VALUES (:cpf_cnpj, :name, :email, :cellphone)";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":cpf_cnpj", $cpf_cnpj);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":cellphone", $cellphone);

        $stmt->execute();
    }

    function searchById($id) {
        $query = "SELECT *
                  FROM tClientes
                  WHERE id = :id";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        return $results;
    }

    function removeById($id) {


        $query = "UPDATE tClientes
                  SET inactivated_at = CURRENT_TIMESTAMP
                  WHERE id = :id
                    AND inactivated_at IS NULL";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();
    }

    function updateById($id, $cpf_cnpj, $name, $email, $cellphone) {
        $query = "UPDATE tClientes
                  SET cpf_cnpj  = :cpf_cnpj,
                      name      = :name,
                      email     = :email,
                      cellphone = :cellphone
                  WHERE id = :id
                    AND inactivated_at IS NULL";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":cpf_cnpj", $cpf_cnpj);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":cellphone", $cellphone);

        $stmt->execute();
    }

    function list($name = null) {
        $query = "SELECT * FROM tClientes WHERE inactivated_at IS NULL";

        if ($name !== null) {
            $search = "%" . $name . "%";
            $query .= " AND name LIKE :name";
        }

        $stmt = $this->pdo->prepare($query);

        if ($name !== null) {
            $stmt->bindParam(":name", $search, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>