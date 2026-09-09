<?php

class DB
{
    private $pdo;

    private const HOST = "php81_dev_environment_database";
    private const DB = "php81_dev_environment";
    private const USER = "root";
    private const PASSWORD = "1234";

    public function __construct()
    {
        try {

            $this->pdo = new PDO(
                "mysql:host=" . self::HOST .
                ";dbname=" . self::DB .
                ";charset=utf8mb4",
                self::USER,
                self::PASSWORD
            );

            $this->pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch(PDOException $e){
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}