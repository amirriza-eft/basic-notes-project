<?php

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($fullName, $email, $password)
    {
        $sql = "
            INSERT INTO users (full_name, email, password)
            VALUES (:full_name, :email, :password)
        ";

        $query = $this->db->prepare($sql);

        $query->execute([
            'full_name' => $fullName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        $this->id = $this->db->lastInsertId();
        $this->email = $email;
        $this->full_name = $fullName;
    }

    public function findByEmail($email)
    {
        $sql = "
        SELECT *
        FROM users
        WHERE email = :email
        LIMIT 1
    ";

        $query = $this->db->prepare($sql);

        $query->execute([
            'email' => $email
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }


    public function login($email, $password)
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }
}

?>