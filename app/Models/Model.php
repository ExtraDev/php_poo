<?php

namespace App\Models;

use Database\DBConnection;
use PDO;

abstract class Model {
    protected $db;
    protected $table;

    public function __construct($db) {
        $this->db = $db;
    }

    public function query(string $sql, array $param = null, bool $single = null) {
        $method = is_null($param) ? 'query' : 'prepare';

        if (strpos($sql, "DELETE") === 0
        || strpos($sql, "UPDATE") === 0
        || strpos($sql, "INSERT") === 0) {
            $stmt = $this->db->getPDO()->$method($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), array($this->db));
            return $stmt->execute($param);
        }

        $fetch = is_null($single) ? 'fetchAll' : 'fetch';

        $stmt = $this->db->getPDO()->$method($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), array($this->db));

        if ($method === 'query'){
            return $stmt->$fetch();
        } else {
            $stmt->execute($param);
            return $stmt->$fetch();
        }
    }

    public function getAll(): array {
        return $this->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
    }

    public function create(array $data, ?array $relations = null) {
        $column = "";
        $values = "";
        $i = 1;

        // Build request
        foreach($data as $key => $value) {
            $comma = $i === count($data) ? "" : ", ";
            $column .= "{$key}{$comma}";
            $values .= ":{$key}{$comma}";
            $i++;
        }

        $query = "INSERT INTO {$this->table} ({$column}) VALUES {$values}";

        return $this->query("INSERT INTO {$this->table} ({$column}) VALUES ({$values})", $data);
    }
}