<?php

class QueryBuilder{
    private $query = '';

    public function select($table, $columns = ['*']){
        $this->query = "SELECT " . implode(', ', $columns) . " FROM $table";
        return $this;
    }

    public function insert($table, $data){
        $columns = implode(', ', array_keys($data)); 
        $values =  implode(', ', array_map(function($value){
            return $value === 'NOW()' ? $value : "'$value'";
        }, array_values($data)));

        $this->query = "INSERT into $table ($columns) VALUES ($values)";
        return $this;
    }

    public function where($condition){
        $this->query .= " WHERE $condition";
        return $this;
    }

    public function update($table, $data){
        $set = implode(', ', $array_map(function($key, $value){
            return $value === 'NOW()' ? "$key=$value" : "$key='$value'";
        }, array_keys($data), $data));

        $this->query = "UPDATE $table SET $set";
        return $this;
    }

    public function getQuery(){
        return $this->query;
    }
}