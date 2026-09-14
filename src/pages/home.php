<?php

$isLoggedIn = $auth->check();

$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);

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
                    Please <a href="/login">login</a> or <a href="/signup">signup</a> to create and manage your notes.
                </div>
            <?php else: ?>

                <form method="POST" action="/notes/create">
                    <input
                            type="text"
                            name="note_title"
                            class="form-control note-input mb-3 w-auto"
                            placeholder="Note title..."
                            maxlength="30"
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

                <form method="GET" action="/notes/search" class="note-filter mb-5">
                    <div class="input-group mb-3">
                        <input
                                type="text"
                                name="notes_search"
                                class="form-control filter-input"
                                placeholder="Search title or content..."
                                value="<?= htmlspecialchars($search); ?>"
                        >
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label for="from" class="filter-label">
                                From
                            </label>
                            <input
                                    type="date"
                                    id="from"
                                    name="from"
                                    class="form-control filter-input"
                                    value="<?= htmlspecialchars($from); ?>"
                            >
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="to" class="filter-label">
                                To
                            </label>
                            <input
                                    type="date"
                                    id="to"
                                    name="to"
                                    class="form-control filter-input"
                                    value="<?= htmlspecialchars($to); ?>"
                            >
                        </div>
                    </div>

                    <div class="row align-items-end g-3">
                        <div class="col-12 col-md-6">
                            <div class="d-flex gap-2">
                                <button
                                        type="submit"
                                        class="btn btn-search-filter"
                                >
                                    Search
                                </button>
                                <a
                                        href="/"
                                        class="btn btn-clear-filter"
                                >
                                    Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <form method="GET" action="/notes/search" class="mb-4">
                    <input
                            type="hidden"
                            name="notes_search"
                            value="<?= htmlspecialchars($search); ?>"
                    >
                    <input
                            type="hidden"
                            name="from"
                            value="<?= htmlspecialchars($from); ?>"
                    >
                    <input
                            type="hidden"
                            name="to"
                            value="<?= htmlspecialchars($to); ?>"
                    >
                    <input
                            type="hidden"
                            name="notes_page"
                            value="1"
                    >
                    <label for="notes_sort" class="filter-label">
                        Sort by
                    </label>
                    <select
                            id="notes_sort"
                            name="notes_sort"
                            class="form-select filter-input w-auto"
                            onchange="this.form.submit()"
                    >
                        <option
                                value="newest"
                                <?= $sort === 'newest' ? 'selected' : ''; ?>
                        >
                            Newest
                        </option>
                        <option
                                value="oldest"
                                <?= $sort === 'oldest' ? 'selected' : ''; ?>
                        >
                            Oldest
                        </option>
                    </select>
                </form>

                <?php if (empty($notes)): ?>

                    <div class="empty">
                        <?php if ($search !== '' || $from !== '' || $to !== ''): ?>
                            No notes found matching your filters.
                        <?php else: ?>
                            You have no notes yet. Start by adding a new note above.
                        <?php endif; ?>
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

                                    <small class="text-secondary d-block mb-3">
                                        Created:
                                        <?= date('M j, Y \a\t H:i', strtotime($note['created_at'])); ?>
                                    </small>

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


                                        <form method="POST" action="/notes/delete">

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
                                            action="/notes/update"
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

                    <?php if ($totalPages > 1): ?>
                        <nav class="mt-5" aria-label="Notes pagination">
                            <ul class="pagination justify-content-center">

                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a
                                                class="page-link pagination-link"
                                                href="/notes/search?notes_search=<?= urlencode($search); ?>&from=<?= urlencode($from); ?>&to=<?= urlencode($to); ?>&notes_sort=<?= urlencode($sort); ?>&notes_page=<?= $page - 1; ?>"
                                        >
                                            ← Previous
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li
                                            class="page-item <?= $i === $page ? 'active' : ''; ?>"
                                    >
                                        <a
                                                class="page-link pagination-link"
                                                href="/notes/search?notes_search=<?= urlencode($search); ?>&from=<?= urlencode($from); ?>&to=<?= urlencode($to); ?>&notes_sort=<?= urlencode($sort); ?>&notes_page=<?= $i; ?>"
                                        >
                                            <?= $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a
                                                class="page-link pagination-link"
                                                href="/notes/search?notes_search=<?= urlencode($search); ?>&from=<?= urlencode($from); ?>&to=<?= urlencode($to); ?>&notes_sort=<?= urlencode($sort); ?>&notes_page=<?= $page + 1; ?>"
                                        >
                                            Next →
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include __DIR__ . "/../components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>