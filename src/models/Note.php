<?php

class Note
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($title, $content)
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

        $this->id = (int) $this->db->lastInsertId();
        $this->title = $title;
        $this->content = $content;

        return $this;
    }
}