<?php

$db = new DB();

$note = new Note($db->getConnection());

$notes = $note->getUserNotes(
        $auth->id()
);


$isLoggedIn = $auth->check();

$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);


if($_SERVER["REQUEST_METHOD"] === "POST"){

    $action = $_POST['action'] ?? "";

    if($action === "add"){

        if(NotePolicy::create($auth->id())){

            $note->create(
                    $auth->id(),
                    $_POST['note_title'],
                    $_POST['note']
            );

            $_SESSION['message'] = "Note created successfully.";
        } else {
            $_SESSION['message'] = "You don't have permission to create note.";
        }
    }

    if($action === "delete"){

        $noteData = $note->find($_POST['id']);

        if(NotePolicy::delete($noteData, $auth->id())){

            $note->delete(
                    $_POST['id'],
                    $auth->id()
            );

            $_SESSION['message'] = "Note deleted successfully.";
        } else {
            $_SESSION['message'] = "You don't have permission to delete notes.";
        }
    }

    if($action === "edit"){

        $noteData = $note->find($_POST['id']);

        if(NotePolicy::update($noteData, $auth->id())){

            $note->update(
                    $_POST['id'],
                    $auth->id(),
                    $_POST['updated_title'],
                    $_POST['updated_note']
            );

            $_SESSION['message'] = "Note updated successfully.";
        } else {
            $_SESSION['message'] = "You don't have permission to update notes.";
        }
    }

    header("Location:/");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<script>

    function showEdit(id){
        document.getElementById("actions-" + id).style.display = "none";
        document.getElementById("edit-" + id).style.display = "block";
    }

    function hideEdit(id){
        document.getElementById("actions-" + id).style.display = "flex";
        document.getElementById("edit-" + id).style.display = "none";
    }
</script>

<body>

<?php include __DIR__ . "/../components/header.php"; ?>

<main class="page-content">
    <div class="container py-5">
        <div class="main-card p-4 p-md-5">
            <h1 class="text-center title mb-5">
                Notes
            </h1>

            <?php if($message): ?>

                <div class="alert alert-success text-center">
                    <?= htmlspecialchars($message); ?>
                </div>

            <?php endif; ?>

            <?php if (!$isLoggedIn): ?>
                <div class="empty guest-box">
                    Please <a href="/?page=login">login</a> or <a href="/?page=signup">signup</a> to create and manage your notes.
                </div>
            <?php else: ?>

                <form method="POST">
                    <input
                            type="hidden"
                            name="action"
                            value="add"
                    >
                    <input
                            type="text"
                            name="note_title"
                            class="form-control note-input mb-3"
                            placeholder="Note title..."
                            maxlength="100"
                            required
                    >
                    <textarea
                            name="note"
                            class="form-control note-input mb-3"
                            rows="5"
                            placeholder="Write your note here..."
                            required
                    ></textarea>

                    <button class="btn btn-primary btn-add px-5 py-2 d-block mx-auto">
                        Add Note
                    </button>
                </form>

                <hr class="border-secondary my-5">

                <h3 class="mb-4">
                    Your Notes
                </h3>

                <?php if (empty($notes)): ?>

                    <div class="empty">
                        You have no notes yet. Start by adding a new note above.
                    </div>

                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($notes as $note): ?>

                            <div class="col-12 col-md-6">
                                <div class="note-card">

                                    <h5 class="note-title">
                                        <?= htmlspecialchars($note['title']); ?>
                                    </h5>

                                    <div class="note-text mb-4">
                                        <?= htmlspecialchars($note['content']); ?>
                                    </div>


                                    <div
                                            class="d-flex gap-2"
                                            id="actions-<?= $note['id']; ?>"
                                    >

                                        <button
                                                type="button"
                                                class="btn-note-edit"
                                                onclick="showEdit(<?= $note['id']; ?>)"
                                        >
                                            Edit
                                        </button>


                                        <form method="POST">

                                            <input
                                                    type="hidden"
                                                    name="action"
                                                    value="delete"
                                            >

                                            <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= $note['id']; ?>"
                                            >

                                            <button class="btn-note-delete">
                                                Delete
                                            </button>

                                        </form>

                                    </div>


                                    <form
                                            method="POST"
                                            id="edit-<?= $note['id']; ?>"
                                            style="display:none;"
                                            class="mt-3"
                                    >

                                        <input
                                                type="hidden"
                                                name="action"
                                                value="edit"
                                        >

                                        <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $note['id']; ?>"
                                        >


                                        <input
                                                class="form-control edit-input mb-2"
                                                name="updated_title"
                                                value="<?= htmlspecialchars($note['title']); ?>"
                                                required
                                        >


                                        <textarea
                                                class="form-control edit-input mb-2"
                                                name="updated_note"
                                                rows="3"
                                                required
                                        ><?= htmlspecialchars($note['content']); ?></textarea>


                                        <div class="d-flex gap-2">

                                            <button class="btn-note-save">
                                                Save Changes
                                            </button>


                                            <button
                                                    type="button"
                                                    class="btn-note-cancel"
                                                    onclick="hideEdit(<?= $note['id']; ?>)"
                                            >
                                                Cancel
                                            </button>

                                        </div>

                                    </form>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include __DIR__ . "/../components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>