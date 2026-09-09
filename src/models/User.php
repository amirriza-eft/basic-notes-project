<?php

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create ($fullName, $email, $password)
    {
        $sql = "
            INSERT INTO users (full_name, email, password)
            VALUES (:full_name, :email, :password)
        ";


    }
}