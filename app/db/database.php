<?php
$dsn        = "mysql:host=mysql;dbname=myfirstdatabase";
$dbUsername = "mysql";
$dbPassword = "mysql";

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Não foi possível conectar no banco de dados: " . $e->getMessage();
}
?>