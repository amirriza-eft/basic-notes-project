<?php

class NotePolicy
{
    public static function update($note, $userId)
    {
        return $note['user_id'] == $userId;
    }

    public static function delete($note, $userId)
    {
        return $note['user_id'] == $userId;
    }
}