<?php
$dsn        = "mysql:host=localhost;dbname=ProjetoBasePHP";
$dbUsername = "root";
$dbPassword = "";

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Não foi possível conectar no banco de dados: " . $e->getMessage();
}
?>