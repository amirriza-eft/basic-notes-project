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

    public function getUserNotes($userId)
    {
        $sql = "
            SELECT *
            FROM notes
            WHERE user_id = :user_id
            ORDER BY created_at DESC
        ";

        $query = $this->db->prepare($sql);

        $query->execute([
            "user_id" => $userId
        ]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($noteId, $userId)
    {
        $sql = "
            DELETE FROM notes
            WHERE id = :noteId AND user_id = :userId
        ";

        $query = $this->db->prepare($sql);

        $query->execute([
            "noteId" => $noteId,
            "userId" => $userId
        ]);
    }

    public function update($id, $userId, $title, $content)
    {
        $sql = "
            UPDATE notes
            SET title = :title,
                content = :content
            WHERE id = :id AND user_id = :user_id
        ";

        $query = $this->db->prepare($sql);

        $query->execute(array(
            'id' => $id,
            'user_id' => $userId,
            'title' => $title,
            'content' => $content
        ));
    }
}