<?php

class Model {
    protected static $tableName = '';
    protected static $collumns = [];
    protected $values = [];

    function __construct($array, $sanitize = 'true')
    {
        $this->loadFromArray($array, $sanitize);
    }

    public function loadFromArray($array, $sanitize = 'true'){
        if ($array) {
            // $conn = Database::getConnection();
            foreach ($array as $key => $value) {
                $cleanValue = $value;

                if (($sanitize === 'true') && ($cleanValue != '')) {
                    $cleanValue = strip_tags(trim($cleanValue));
                    $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);
                    // $cleanValue = mysqli_real_escape_string($conn, $cleanValue);
                }

                $this->$key = $cleanValue;
            }
            // $conn->close();
        }
    }

    public function __get($key) {
        return $this->values[$key];
    }

    public function __set($key, $value) {
        $this->values[$key] = $value;
    }

    public function getValues() {

        return $this->values;
    }

    public static function getOne($filters = [], $collumns = '*') {
        $classe = get_called_class();
        $result = static::getResultSetFromSelect($filters, $collumns);
        
        return $result ? new $classe($result->fetch_assoc()) : null;
    }

    public static function get($filters = [], $collumns = '*') {
        $objects = [];
        $result = static::getResultSetFromSelect($filters, $collumns);
        $classe = get_called_class();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                array_push($objects,  new $classe($row));
            }
        }
        return $objects;
    }

    public static function getResultSetFromSelect($filters = [], $columns = '*') {
        $sql = "SELECT $columns FROM " . static::$tableName . static::getFilters($filters);
        $result = Database::getResultFromQuery($sql);
        
        if ($result->num_rows === 0) {
            return null;
        } else {
            return $result;
        }
    }

    private static function getFilters($filters) {
        $sql = '';

        if (count($filters) > 0) {
            $sql .= " WHERE 1 = 1";
            foreach ($filters as $column => $value) {
                if ($column == 'raw'){
                    $sql .= " AND {$value}";
                } else {
                    $sql .= " AND $column = " .static::getFormatedValue($value);
                }
            }
        }

        return $sql;
    }

    public function insert() {
        $sql = "INSERT INTO " . static::$tableName ." (" . implode(",", static::$collumns) . ") 
        VALUES (";
        foreach (static::$collumns as $col) {
            $sql .= static::getFormatedValue($this->$col) . ",";
        }
        $sql[strlen($sql) -1] = ')';
        $id = Database::executeSQL($sql);
        $this->id = $id;
    }

    public function update() {
        $sql = "UPDATE " . static::$tableName ." SET";
        foreach (static::$collumns as $col) {
            $sql .= " $col = " . static::getFormatedValue($this->$col) . ",";
        }
        $sql[strlen($sql) -1] = ' ';
        $sql .= ' WHERE id = ' . $this->id;
        Database::executeSQL($sql);
    }

    public function delete() {
        static::deleteById($this->id);
    }

    public static function deleteById($id){
        $sql = "DELETE FROM " . static::$tableName ." WHERE id = {$id}";
        Database::executeSQL($sql);
    }

    public static function GetCount($filters = []) {
        $result = static::getResultSetFromSelect($filters, 'count(*) as count ');
        return $result->fetch_assoc()['count'];
    }

    public function getNextTime() {
        if (!$this->time1) {
            return 'time1';
            
        }elseif (!$this->time2) {
            return 'time2';

        }elseif (!$this->time3) {
            return 'time3';

        }elseif (!$this->time4) {
            return 'time4';

        }else {
            return null;
        }
    }

    public function getActiveClock() {
        $nextTime = $this->getNextTime();
        if (($nextTime === 'time1') || ($nextTime === 'time3')){
            return 'exitTime';
        } elseif (($nextTime === 'time2') || ($nextTime === 'time4')) {
            return 'workedInterval';
        } else {
            return null;
        }
    }

    private static function getFormatedValue($value) {

        if (is_null($value)) {
            return 'null';
        } elseif (gettype($value) === 'string'){
            return "'" .$value. "'";
        } else {
            return $value;
        }
    }
}