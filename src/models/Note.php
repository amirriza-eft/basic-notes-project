<?php

class Note
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($user_id, $title, $content)
    {
        $sql = "
        INSERT INTO notes(user_id, title, content)
        VALUES(:user_id, :title, :content)
        ";

        $query = $this->db->prepare($sql);

        $query->execute([
            "user_id" => $user_id,
            "title" => $title,
            "content" => $content
        ]);

        $this->id = (int) $this->db->lastInsertId();
        $this->title = $title;
        $this->content = $content;

        return $this;
    }
}