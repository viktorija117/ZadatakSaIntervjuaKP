<?php

class UserRepository {

    private $db;
    private $querybuilder;

    public function __construct(Database $db, QueryBuilder $querybuilder){
        $this->db = Database::getInstance()->getConnection();
        $this->querybuilder = $querybuilder;
    }

    public function findByEmail($email){
        $query = $this->querybuilder->select('user', ['*'])->where("email = '$email'")->getQuery();
        $result = $this->db->query($query);

        return $result->fetch_assoc();
    }

    public function insertUser($email, $password){
        $query = $this->querybuilder->insert('user', ['email' => $email, 'password' => $password])->getQuery();
        $result = $this->db->query($query);

        return $this->db->insert_id;
    }

    public function logAction($userId, $action){
        $query = $this->querybuilder->insert('user_log', ['user_id' => $userId, 'action' => $action, 'log_time' => 'NOW()'])->getQuery();
        $result = $this->db->query($query);
    }

}