<?php
class Database {
    private static $dsn        = "mysql:host=localhost;dbname=ProjetoBasePHP";
    private static $dbUsername = "root";
    private static $dbPassword = "";
    private static $instance   = null;
    private $pdo;
    public $lastQuery = null;

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
        return self::$instance;
    }

    public function executeQuery($query, $params = []) {
        $this->lastQuery = $query;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function getQueryWithParams($query, $params) {

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $value = implode(', ', array_map([$this->pdo, 'quote'], $value));
                $query = preg_replace('/' . preg_quote($key) . '\b/', $value, $query, 1); // Substituir apenas a primeira ocorrência
            } else {
                $query = str_replace($key, $this->pdo->quote($value), $query);
            }
        }
        return $query;
    }
}
?>