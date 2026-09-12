<?php

class NoteController
{

    private $auth;
    private $note;

    public function __construct($auth, $note)
    {
        $this->auth = $auth;
        $this->note = $note;
    }

    public function store()
    {
        $userId = $this->auth->id();

        if (!NotePolicy::create($userId)) {
            $_SESSION['message'] = "You don't have permission to create note.";
            header('Location: /');
            exit;
        }

        $title = trim($_POST['note_title'] ?? '');
        $content = trim($_POST['note'] ?? '');

        if ($title === '' || $content === '') {
            $_SESSION['message'] = "Title and content are required.";
            header('Location: /');
            exit;
        }

        if (strlen($title) > 30) {
            $_SESSION['message'] = "Note title is too long.";
            header('Location: /');
            exit;
        }

        if (strlen($content) > 300) {
            $_SESSION['message'] = "Note content has to be less than 300 characters.";
            header('Location: /');
            exit;
        }

        $this->note->create(
            $userId,
            $title,
            $content
        );

        $_SESSION['message'] = "Note created successfully.";

        header('Location: /');
        exit;
    }

    public function update() {
        $userId = $this->auth->id();
        $noteId = $_POST['id'] ?? 0;

        if(!$noteId) {
            $_SESSION['message'] = "Invalid note.";
            header('Location: /');
            exit;
        }

        $noteData = $this->note->find($noteId);

        if (!$noteData) {
            $_SESSION['message'] = "Note not found.";
            header('Location: /');
            exit;
        }

        if (!NotePolicy::update($noteData, $userId)) {
            $_SESSION['message'] = "You don't have permission to update note.";
            header('Location: /');
            exit;
        }

        $title = trim($_POST['updated_title'] ?? '');
        $content = trim($_POST['updated_note'] ?? '');

        if ($title === '' || $content === '') {
            $_SESSION['message'] = "Title and content are required.";
            header('Location: /');
            exit;
        }

        if (strlen($title) > 30) {
            $_SESSION['message'] = "Note title is too long.";
            header('Location: /');
            exit;
        }

        if (strlen($content) > 300) {
            $_SESSION['message'] = "Note content has to be less than 300 characters.";
            header('Location: /');
            exit;
        }

        $this->note->update(
            $noteId,
            $userId,
            $title,
            $content
        );

        $_SESSION['message'] = "Note updated successfully.";

        header('Location: /');
        exit;
    }

    public function delete() {
        $userId = $this->auth->id();
        $noteId = $_POST['id'] ?? 0;

        if(!$noteId) {
            $_SESSION['message'] = "Invalid note.";
            header('Location: /');
            exit;
        }

        $noteData = $note = $this->note->find($noteId);

        if (!$note) {
            $_SESSION['message'] = "Note not found.";
            header('Location: /');
            exit;
        }

        if (!NotePolicy::delete($noteData, $userId)) {
            $_SESSION['message'] = "You don't have permission to delete note.";
            header('Location: /');
            exit;
        }

        $this->note->delete($noteId, $userId);

        $_SESSION['message'] = "Note deleted successfully.";

        header('Location: /');
        exit;
    }

}