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

    public function query(string $sql, int $param = null, bool $single = null) {
        $method = is_null($param) ? 'query' : 'prepare';
        $fetch = is_null($single) ? 'fetchAll' : 'fetch';

        $stmt = $this->db->getPDO()->$method($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), array($this->db));

        if ($method === 'query'){
            return $stmt->$fetch();
        } else {
            $stmt->execute(array($param));
            return $stmt->$fetch();
        }
    }

    public function getAll(): array {
        return $this->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
    }
}