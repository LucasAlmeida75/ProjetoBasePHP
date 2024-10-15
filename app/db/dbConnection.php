<?php
class Database {
    private static $dsn        = "mysql:host=localhost;dbname=ProjetoBasePHP";
    private static $dbUsername = "root";
    private static $dbPassword = "";
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            $this->pdo = new PDO(self::$dsn, self::$dbUsername, self::$dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Não foi possível conectar no banco de dados: " . $e->getMessage();
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
?>