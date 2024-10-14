<?php

class Cliente {

    function insert($cpf_cnpj, $name, $email, $cellphone) {
        require_once "../app/db/dbConnection.php";

        $query = "INSERT INTO
                  tClientes (cpf_cnpj, name, email, cellphone)
                  VALUES (:cpf_cnpj, :name, :email, :cellphone)";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":cpf_cnpj", $cpf_cnpj);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":cellphone", $cellphone);

        $stmt->execute();
        $pdo = $stmt = null;
    }

    function searchById($id) {
        require_once "../app/db/dbConnection.php";

        $query = "SELECT *
                  FROM tClientes
                  WHERE id = :id";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo = $stmt = null;

        return $results;
    }

    function removeById($id) {
        require_once "../app/db/dbConnection.php";

        $query = "UPDATE tClientes
                  SET inactivated_at = CURRENT_TIMESTAMP
                  WHERE id = :id
                    AND inactivated_at IS NULL";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo = $stmt = null;

        return $results;
    }

    function list($name = null) {
        require_once "../app/db/dbConnection.php";

        $query = "SELECT * FROM tClientes WHERE inactivated_at IS NULL";

        if ($name !== null) {
            $search = "%" . $name . "%";
            $query .= " AND name LIKE :name";
        }

        $stmt = $pdo->prepare($query);

        if ($name !== null) {
            $stmt->bindParam(":name", $search, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>