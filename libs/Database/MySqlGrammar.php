<?php

namespace Libs\Database;

class MySqlGrammar
{
  public static function insertInto($params, $table)
  {
    // "INSERT INTO todos (content, created_at, updated_at) VALUES(:content, :created_at, :updated_at);"
    $addColon = function($str) {
      return ':'.$str;
    };
    $columnsArray = array_keys($params);
    $columns = implode(', ', $columnsArray);
    $placeholdersArray = array_map($addColon, $columnsArray);
    $placeholders = implode(', ', $placeholdersArray);

    $query = "INSERT INTO {$table} ({$columns}) VALUES({$placeholders});";
    return $query;
  }

  public static function updateOneRecord($params, $table)
  {
    // "UPDATE todos SET content = :content, updated_at = :updated_at WHERE id = :id"
    $addPlaceholder = function($str) {
      return $str." = ".":".$str;
    };
    $columnsArray = array_keys($params);
    $targetArray = array_map($addPlaceholder, $columnsArray);
    $target = implode(', ', $targetArray);

    $query = "UPDATE {$table} SET {$target} WHERE id = :id;";
    return $query;
  }
}