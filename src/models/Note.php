<?php

class Note
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($user_id, $title, $content, $isGlobal)
    {
        $sql = "
        INSERT INTO notes(user_id, title, content, is_global)
        VALUES(:user_id, :title, :content, :is_global)
        ";

        $query = $this->db->prepare($sql);

        $query->execute([
            "user_id" => $user_id,
            "title" => $title,
            "content" => $content,
            "is_global" => $isGlobal
        ]);

        $this->id = (int) $this->db->lastInsertId();
        $this->title = $title;
        $this->content = $content;
        $this->is_global = $isGlobal;

        return $this;
    }

    public function getNotes(
        $userId,
        $scope,
        $search,
        $from,
        $to,
        $sort,
        $limit,
        $offset
    ) {
        $sql = "
            SELECT notes.*, users.full_name AS creator_name
            FROM notes
            INNER JOIN users ON users.id = notes.user_id
        ";

        $params = [];

        if ($scope === 'private') {
            $sql .= "
                WHERE user_id = :user_id
            ";

            $params["user_id"] = $userId;
        } else {
            $sql .= "
                WHERE is_global = 1
            ";
        }

        if ($search !== '') {
            $sql .= "
                AND (
                    title LIKE :search_title
                    OR content LIKE :search_content
                )
            ";

            $searchValue = "%" . $search . "%";

            $params["search_title"] = $searchValue;
            $params["search_content"] = $searchValue;
        }

        if ($from !== '') {
            $sql .= " AND created_at >= :from";
            $params["from"] = $from . " 00:00:00";
        }

        if ($to !== '') {
            $sql .= " AND created_at <= :to";
            $params["to"] = $to . " 23:59:59";
        }

        if ($sort === 'oldest') {
            $sql .= " ORDER BY notes.created_at ASC";
        } else {
            $sql .= " ORDER BY notes.created_at DESC";
        }

        $limit = (int) $limit;
        $offset = (int) $offset;

        $sql .= " LIMIT $limit OFFSET $offset";

        $query = $this->db->prepare($sql);

        $query->execute($params);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countNotes(
        $userId,
        $scope,
        $search,
        $from,
        $to
    ) {
        $sql = "
        SELECT COUNT(*)
        FROM notes
    ";

        $params = [];

        if ($scope === 'private') {
            $sql .= "
                WHERE user_id = :user_id
            ";

            $params["user_id"] = $userId;
        } else {
            $sql .= "
                WHERE is_global = 1
            ";
        }

        if ($search !== '') {
            $sql .= "
                AND (
                    title LIKE :search_title
                    OR content LIKE :search_content
                )
            ";

            $searchValue = "%" . $search . "%";

            $params["search_title"] = $searchValue;
            $params["search_content"] = $searchValue;
        }

        if ($from !== '') {
            $sql .= " AND created_at >= :from";
            $params["from"] = $from . " 00:00:00";
        }

        if ($to !== '') {
            $sql .= " AND created_at <= :to";
            $params["to"] = $to . " 23:59:59";
        }

        $query = $this->db->prepare($sql);

        $query->execute($params);

        return (int) $query->fetchColumn();
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

    public function find($id)
    {
        $sql = "
            SELECT *
            FROM notes
            WHERE id = :id
        ";

        $query = $this->db->prepare($sql);

        $query->execute([
            "id" => $id
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}