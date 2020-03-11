<?php

namespace Libs;
use PDO;

class Database
{
    const DSN = 'mysql:host=localhost;dbname=todo_app_development;charset=utf8mb4';
    const DB_USER = 'root';
    const DB_PASS = null;

    private static $instance = null;
    private $pdo = null;

    //SingletonÉpÉ^Å[Éì
    public static function getInstance() :Database
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
            self::$instance->pdo = new PDO(self::DSN, self::DB_USER, self::DB_PASS);
            self::$instance->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }

    //SQLé¿çs
    public function execute(string $sql, array $params = []) :bool
    {
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':'.$key, $value);
        }
        return $stmt->execute();
    }

    //SELECTï∂é¿çs
    public function query(string $sql, array $params = []) :array
    {
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':'.$key, $value);
        }
        $stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
