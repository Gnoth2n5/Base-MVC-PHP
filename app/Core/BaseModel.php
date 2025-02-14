<?php

namespace App\Core;

use PDO;
use PDOException;

abstract class BaseModel
{
    protected static $table;
    protected static $primaryKey = 'id';
    protected $attributes = [];
    protected static $pdo;

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    public static function setConnection(PDO $pdo)
    {
        static::$pdo = $pdo;
    }

    public static function find($id)
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;
        $stmt = static::$pdo->prepare("SELECT * FROM $table WHERE $primaryKey = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new static($result) : null;
    }

    public static function all()
    {
        $table = static::$table;
        $stmt = static::$pdo->query("SELECT * FROM $table");
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function where($column, $value)
    {
        $table = static::$table;
        $stmt = static::$pdo->prepare("SELECT * FROM $table WHERE $column = ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function orderBy($column, $direction = 'ASC')
    {
        $table = static::$table;
        $stmt = static::$pdo->query("SELECT * FROM $table ORDER BY $column $direction");
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function create($attributes)
    {
        $table = static::$table;
        $columns = array_keys($attributes);
        $values = array_values($attributes);
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $stmt = static::$pdo->prepare("INSERT INTO $table (" . implode(',', $columns) . ") VALUES ($placeholders)");
        if ($stmt->execute($values)) {
            return new static($attributes);
        }
        return null;
    }

    public function update($attributes)
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;
        $set = implode(' = ?, ', array_keys($attributes)) . ' = ?';
        $stmt = static::$pdo->prepare("UPDATE $table SET $set WHERE $primaryKey = ?");
        return $stmt->execute([...array_values($attributes), $this->attributes[$primaryKey]]);
    }

    public function save()
    {
        if (isset($this->attributes[static::$primaryKey])) {
            return $this->update($this->attributes);
        } else {
            return static::create($this->attributes);
        }
    }

    public function delete()
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;
        $stmt = static::$pdo->prepare("DELETE FROM $table WHERE $primaryKey = ?");
        return $stmt->execute([$this->attributes[$primaryKey]]);
    }
}
    