<?php

namespace Libs\Database;
use PDO;
use Libs\Database\Database;
use Libs\Database\MySqlGrammar as Query;

class Model {
  protected static $table;
  protected $db;
  protected $properties;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public static function find($id)
  {
    $db = Database::getInstance();
    $table = static::$table;
    $query = "SELECT * FROM {$table} WHERE id = :id LIMIT 1;";
    $params = ['id' => $id];
    return static::arrayToObject($db->query($query, $params)[0]);
  }

  public static function all()
  {
    $db = Database::getInstance();
    $table = static::$table;
    $query = "SELECT * FROM {$table};";
    return static::arrayToObjectList($db->query($query));
  }

  public function create($params)
  {
    $paramsWithDate = $this->_joinDatetimesInsert($params);
    $permittedParams = $this->permitProperties($paramsWithDate);
    $query = Query::insertInto($permittedParams, static::$table);
    $this->db->execute($query, $permittedParams);
  }

  public function update($params, $id)
  {
    $params['updated_at'] = date('Y-m-d H:i:s');
    $permittedParams = $this->permitProperties($params);
    $query = Query::updateOneRecord($permittedParams, static::$table);
    $this->db->execute($query, $permittedParams);
  }

  public function destroy($id = null)
  {
    if (!isset($id)) {
      $id = $this->id;
    }
    $table = static::$table;
    $query = "DELETE FROM {$table} WHERE id = :id";
    $this->db->execute($query, ['id' => $id]);
  }

  // --- protected members ---

  protected function permitProperties($params)
  {
    $results = [];
    foreach ($this->properties as $p) {
      if (isset($params[$p])) {
        $results[$p] = $params[$p];
      }
    }
    return $results;
  }

  protected static function arrayToObject(Array $record)
  {
    $obj = new static();
    foreach($record as $key => $val) {
      $obj->$key = $val;
    }
    return $obj;
  }

  protected static function arrayToObjectList(Array $records)
  {
    $objectList = [];
    foreach ($records as $r) {
      array_push($objectList, static::arrayToObject($r));
    }
    return $objectList;
  }

  protected function _joinDatetimesInsert($params)
  {
    $params['created_at'] = date('Y-m-d H:i:s');
    $params['updated_at'] = date('Y-m-d H:i:s');
		return $params;
  }
}