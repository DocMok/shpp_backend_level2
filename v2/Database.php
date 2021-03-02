<?php

class Database
{
    private $connection = null;
    private array $config = array(
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'taskList',
        'table' => 'items'
    );

    public function __construct($table = 'items')
    {
        if (isset($table)) {
            $this->config['table'] = $table;
        }
    }

    public function connect(): bool|mysqli
    {
        if ($this->connection == null) {
            $config = $this->config;
            $this->connection = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);

            if (!$this->connection) {
                die("Cannot connect to database server");
            }
        }
        return $this->connection;
    }

    public function getTableName()
    {
        return $this->config['table'];
    }

}