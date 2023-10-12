<?php

namespace Aden\aFramework\SQL;

use PDO;
use PDOException;

class Database {
    protected $conn, $type;

    protected const PARAM_TYPES = [
        "string" => PDO::PARAM_STR,
        "integer" => PDO::PARAM_INT,
        "bool" => PDO::PARAM_BOOL,
        "dobule" => PDO::PARAM_INT
    ];

    /**
     * Constructs a Database object.
     * 
     * @param String $type The type of server you're going to connect to. Bald Framework 1.0 supports SQLite and MySQL.
     * @param Array|Null $auth The auth data for MySQL. First value should be host, second is user, third is password, fourth is the database. Set to null for SQLite
     * @param String|Null $name The name of the .db file for SQLite. Defaults to NULL.
     */
    public function __construct($type="mysql", $auth=["127.0.0.1", "root", "", "aFramework"], $name=null) {
        if(strtolower($type) == "mysql") {
            $this->conn = new PDO("mysql:host=$auth[0];dbname=$auth[3];port=3306", $auth[1], $auth[2]);
        } else {
            $this->conn = new PDO("sqlite:".__DIR__."/Databases/$name.db");
        }
    }

    /**
     * Sends a manually entered query to the database. Use params to escape inputs.
     * 
     * @param String $sql The query.
     * @param Array|Null $params The params array. PDO will replace any question marks (?) with the values in the params array. It goes in order.
     * 
     * @return SQLResult The SQL result.
     */
    public function Query($sql, $params=null) {
        try {
            $s = $this->conn->prepare($sql);
            $s->execute($params);
        } catch(PDOException $e) {
            return new SQLResult($e->getMessage());
        }

        return new SQLResult($s);
    }
    /* 
        Database::CreateTable("users", ["id" => ["type" => "INT", "primary" => true], "name" => ["type" => "TEXT", "default" => ""]])
    */
    public function CreateTable($name, $cols) {
        $q = "CREATE TABLE IF NOT EXISTS `$name` (";
        $primary = null;

        foreach($cols as $key => $val) {
            $default = "";

            if(isset($val["primary"])) {
                $primary = $key;
            }

            if(isset($val["default"])) {
                $default = " DEFAULT '{$val['default']}'";
            }

            $q .= "`$key` {$val["type"]}$default, ";
        }

        if($primary) {
            $q .= "PRIMARY KEY ($primary)";
        }

        $q .= ");";

        return $this->Query($q);
    }

    /**
     * A function to quickly run a select query on a specific table. Note, aFramework 1.0 does not support OR for $where.
     * 
     * @param String $table The table to select from.
     * @param String $cols The columns to select. Format it like SQL, ie "`col1`, `col2`, `col3`" or "*" for all.
     * @param Array|Null $where An array for the where statement. Struct of array should be something like ["col1" => "some value"].
     * 
     * @return SQLResult The results from the query.
     */
    public function Select($table, $cols, $where=null) {
        $q = "SELECT $cols FROM $table";
        if($where) {
            $q .= " WHERE ";

            $i = 0;
            foreach($where as $key => $val) {
                if($i >= 1) {
                    $q .= " AND $key = :$key";
                } else {
                    $q .= "$key = :$key";
                }

                $i++;
            }
        }

        try {
            $s = $this->conn->prepare($q);
        } catch(PDOException $e) {
            return new SQLResult($e->getMessage());
        }

        if($where) {
            foreach($where as $key => $val) {
                $t = $this::PARAM_TYPES[gettype($val)] ?? PDO::PARAM_STR;

                $s->bindValue($key, $val, $t);
            }
        }

        try {
            $s->execute();
        } catch(PDOException $e) {
            return new SQLResult($e->getMessage());
        }

        return new SQLResult($s);
    }
}