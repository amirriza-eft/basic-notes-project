<?php

require __DIR__ . "/../config/database.php";
require __DIR__ . "/../models/Note.php";


$db = new DB();

$note = new Note($db->getConnection());

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $action = $_POST['action'] ?? "";

    if($action === "add"){

        $note->create(
                $_POST['note_title'],
                $_POST['note']
        );

//        echo $note->id;
//        echo $note->title;
//        echo $note->content;
    }

    header("Location:/");
    exit;
}
?>

<!DOCTYPE html>
<html lang="eng" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Note</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    min-height:100vh;
    background:linear-gradient(135deg,#020617,#0f172a,#172554);
    font-family:Arial,sans-serif;
    color:white;
}

.main-card{
    background:#0b1b36;
    border-radius:20px;
    box-shadow:0 20px 50px rgba(0,0,0,.4);
    border:1px solid rgba(255,255,255,.08);
}

.title{
    font-size:42px;
    font-weight:700;
}

.note-input{
    background:#071426;
    border:1px solid #1e3a8a;
    color:white;
    border-radius:15px;
    resize:none;
}

.note-input:focus{
    background:#071426;
    color:white;
    border-color:#3b82f6;
    box-shadow:0 0 15px rgba(59,130,246,.3);
}

.note-input::placeholder{
    color:#94a3b8;
}

.note-card{
    background:#10254a;
    border-radius:18px;
    padding:20px;
    transition:.3s;
    border:1px solid rgba(255,255,255,.08);
}

.note-card:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 35px rgba(0,0,0,.35);
}

.note-text{
    color:#e2e8f0;
    font-size:17px;
    line-height:1.8;
    white-space:pre-wrap;
}

.btn-add{
    background:#2563eb;
    border:none;
    border-radius:12px;
}

.btn-add:hover{
    background:#1d4ed8;
}

.empty{
    color:#94a3b8;
    text-align:center;
    padding:40px;
}
</style>
</head>

<body>

<?php include __DIR__ . "/../components/header.php"; ?>

<div class="container py-5">
    <div class="main-card p-4 p-md-5">
        <h1 class="text-center title mb-5">
            Notes
        </h1>

        <form method="POST">

            <input type="hidden" name="action" value="add">

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
                placeholder="write your note here..."
                required
            ></textarea>

            <button class="btn btn-primary btn-add px-5 py-2 center d-block mx-auto">
                Add Note
            </button>
        </form>

        <hr class="border-secondary my-5">

        <h3 class="mb-4">
            Your Notes
        </h3>

            <?php if (empty($_SESSION['notes'])): ?>
                <div class="empty">
                    You have no notes yet. Start by adding a new note above.
                </div>
            <?php else: ?>

                <?php foreach ($_SESSION['notes'] as $index => $note): ?>
                    <div class="col-12 col-md-6">
                        <div class="note-card">
                            <div class="note-text mb-4">
                                <?= htmlspecialchars($note); ?>
                            </div>

                            <div class="d-flex gap-2">

                                <form method="POST" class="flex-grow-1">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="id" value="<?= $index ?>">

                                    <input
                                        class="form-control mb-2 bg-dark text-white border-secondary"
                                        name="updated_note"
                                        value="<?= htmlspecialchars($note); ?>"
                                    >

                                    <button class="btn btn-warning btn-sm w-100">
                                        Edit
                                    </button>
                                </form>

                                <form method="POST">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $index ?>">

                                    <button class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php include __DIR__ . "/../components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>