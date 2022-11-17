<?php

namespace App\Models;

use PDO;
use Config;

abstract class ModelPDO extends PDO{
    
    private static $pdo;

    protected $table;
    protected $primaryKey = 'id';
    private $fields = array();

    public function __construct($schema, $data = false) {
        $this->fields['id'] = array('value' => null, 'type' => PDO::PARAM_INT);
        foreach ($schema as $name => $type) {
            $this->fields[$name] = array('value' => null, 'type' => $type);
        }
        if ($data) {
            foreach ($data as $column => $value) {
                $prop = self::getPropertyName($column);
                $this->fields[$prop]['value'] = $value;
            }
        }
    }

    protected static function getPDO() {
        if (!isset(self::$pdo)) {
            self::$pdo = new PDO(
                'mysql:dbname=' . Config::DB . ';host=' . Config::HOST,
                Config::USER,
                Config::PASS
            );
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        return self::$pdo;
    }

    public function getTable()
    {
        return $this->table;
    }

    protected static function getModelName() {
        return strtolower(get_called_class());
    }
    
    protected static function getFieldName($field) {
        return self::getModelName() . '_' . $field;
    }

    protected static function getPropertyName($prop) {
        return substr($prop, strlen(self::getModelName()) + 1);
    }

    protected static function getBindName($field) {
        return ":{$field}";
    }

    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    public static function get($id) {
        $primaryKey = self::getPrimaryKey();
        return self::getBy($primaryKey, $id);
    }

    public function getBy($field, $value)
    {
        $fieldName = self::getFieldName($field);
        $bindName = self::getBindName($field);
        $tableName = self::getTable();
        $q = "SELECT * FROM ($tableName) ";
        $q .= "WHERE {$fieldName} = {$bindName}";
        $sth = self::getPDO()->prepare($q);
        $sth->bindParam($bindName, $value);
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $modelName = self::getModelName();
            return new $modelName($data);
        }
        return null;
    }

    public function save() {
        $tableName = self::$table;
        if ($this->fields['id']['value'] != null) {
            foreach ($this->fields as $field => $f) {
                if ($field != 'id' && $f['value'] != null) {
                    $fieldName = self::getFieldName($field); 
                    $bindName = self::getBindName($field);
                    $fields[] = "{$fieldName} = {$bindName}";
                }
            }
            $fieldName = self::getFieldName('id');
            $bindName = self::getBindName('id');
            $set = implode(', ', $fields);
            $q = "UPDATE {$tableName} ";
            $q .= "SET {$set} ";
            $q .= "WHERE {$fieldName} = {$bindName}";
        } else {
            foreach ($this->fields as $field => $f) {
                if ($field != 'id' && $f['value'] != null) {
                    $cols[] = self::getFieldName($field);
                    $binds[] = self::getBindName($field);
                }
            }
            $columns = implode(', ', $cols);
            $bindings = implode(', ', $binds);
            $q = "INSERT INTO {$tableName} ";
            $q .= "({$columns}) VALUES ({$binds})";
        }
        $sth = ModelPDO::getPDO()->prepare($q);
        foreach ($this->fields as $field => $f) {
            $value = $f['value'];
            if ($f['value'] != null) {
                $sth->bindValue(self::getBindName($field), $f['value'], $f['type']); 
            }
        }
        //echo "{$sth->queryString}\n";
        return $sth->execute();
    }

    public function delete() {
        $tableName = self::getTable();
        $fieldName = self::getFieldName('id');
        $bindName = self::getBindName('id');
        if ($this->fields['id']['value'] != null) {
            $q = "DELETE FROM {$tableName} ";
            $q .="WHERE {$fieldName} = {$bindName}";
            $sth = ModelPDO::getPDO()->prepare($q);
            return $sth->execute();
        }
    }

    public static function all() {

        $tableName = self::getTable();
        $q = "SELECT * FROM ($tableName)";
        $sth = self::getPDO()->prepare($q);
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if($data){
            $modelName = self::getModelName();
            return new $modelName($data);
        }
        return null;
    }

    public function __set($name, $value) {
        if (array_key_exists($name, $this->fields)) {
            $this->fields[$name]['value'] = $value;
        }
    }

    public function __get($name) {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name]['value'];
        }
    }
}

?>