<?php

namespace Libs;
use PDO;

class Database
{
    private static $DSN;
    private static $DB_USER;
    private static $DB_PASS;

    private static $instance = null;
    private $pdo = null;

    private static function init()
    {
        self::$DSN = env('DSN');
        self::$DB_USER = env('DB_USER');
        self::$DB_PASS = env('DB_PASS');
    }

    //SingletonÉpÉ^Å[Éì
    public static function getInstance() :Database
    {
        if (is_null(self::$instance)) {
            self::init();
            self::$instance = new Database();
            self::$instance->pdo = new PDO(self::$DSN, self::$DB_USER, self::$DB_PASS);
            self::$instance->pdo->setAttribute(PDO::ATTR_ERRMODE,       PDO::ERRMODE_EXCEPTION);
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
