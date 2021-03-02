<?php

class Database
{
    const HOST = 'localhost';
    const USER = 'root';
    const PASSWORD = '';
    const DATABASE = 'taskList';
    private $table = 'items';
    private $db = null;

    public function __construct($table = 'items')
    {
        if (isset($table)) {
            $this->table = $table;
        }
    }

    public function connect(): PDO
    {
        if ($this->db == null) {
            try {
                $this->db = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DATABASE, self::USER, self::PASSWORD);

            } catch (PDOException $e) {
                die("DB connection error: $e");
            }
        }
        return $this->db;
    }

    public function getTableName()
    {
        return $this->table;
    }

}