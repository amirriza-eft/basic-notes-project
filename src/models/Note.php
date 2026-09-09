<?php

class Note
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addNote($title, $content)
    {
        $sql = "
        INSERT INTO notes(title, content)
        VALUES(:title, :content)
        ";

        $query = $this->db->prepare($sql);

        $query->execute([
            "title" => $title,
            "content" => $content
        ]);

        return (int) $this->db->lastInsertId();
    }
}