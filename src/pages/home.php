<?php

$isLoggedIn = $auth->check();

$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);

$scope = $scope ?? 'private';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
    >
    <title>Notes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>

<?php include __DIR__ . "/../components/header.php"; ?>

<main class="page-content">
    <div class="container py-5">
        <div class="main-card p-4 p-md-5">

            <!-- PAGE TITLE -->
            <h1 class="text-center title mb-4">
                Notes
            </h1>

            <!-- FLASH MESSAGE -->
            <?php if ($message): ?>
                <div class="alert alert-success text-center">
                    <?= htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- GUEST -->
            <?php if (!$isLoggedIn && $scope !== 'global'): ?>
                <div class="d-flex justify-content-center mb-3">
                    <div class="btn-group" role="group" aria-label="Note scope">
                        <a
                                href="/"
                                class="btn btn-primary"
                        >
                            Personal
                        </a>
                        <a
                                href="/notes/search?scope=global"
                                class="btn btn-outline-primary"
                        >
                            Global
                        </a>
                    </div>
                </div>
                <div class="empty guest-box">

                    Please
                    <a href="/login">login</a>
                    or
                    <a href="/signup">signup</a>
                    to create and manage your notes.

                </div>
            <?php else: ?>

                <!-- ACTION BUTTONS -->
                <?php if ($isLoggedIn): ?>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <button
                                type="button"
                                class="btn btn-primary btn-add"
                                data-bs-toggle="modal"
                                data-bs-target="#addNoteModal"
                        >
                            + Add Note
                        </button>
                        <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#searchModal"
                        >
                            Search
                        </button>
                    </div>
                <?php endif; ?>

                <!-- PRIVATE / GLOBAL -->
                <div class="d-flex justify-content-center mb-1">
                    <div
                            class="btn-group"
                            role="group"
                            aria-label="Note scope"
                    >
                        <a
                                href="/"
                                class="btn <?= $scope === 'private'
                                        ? 'btn-primary'
                                        : 'btn-outline-primary'; ?>"
                        >
                            Personal
                        </a>
                        <a
                                href="/notes/search?scope=global"
                                class="btn <?= $scope === 'global'
                                        ? 'btn-primary'
                                        : 'btn-outline-primary'; ?>"
                        >
                            Global
                        </a>
                    </div>
                </div>

                <!-- ADD NOTE MODAL -->
                <?php include __DIR__ . "/../components/addNoteModal.php"; ?>

                <!-- SEARCH MODAL -->
                <?php include __DIR__ . "/../components/searchNoteModal.php"; ?>

                <!-- NOTES HEADER -->
                <div
                        class="d-flex justify-content-between align-items-center mb-4"
                >

                    <h3 class="mb-0">
                        <?= $scope === 'global'
                                ? 'Global Notes'
                                : 'My Notes'; ?>
                    </h3>

                    <!-- SORT -->
                    <form
                            method="GET"
                            action="/notes/search"
                    >
                        <input
                                type="hidden"
                                name="scope"
                                value="<?= htmlspecialchars($scope); ?>"
                        >
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
                        <label
                                for="notes_sort"
                                class="filter-label"
                        >
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
                                    <?= $sort === 'newest'
                                            ? 'selected'
                                            : ''; ?>
                            >
                                Newest
                            </option>
                            <option
                                    value="oldest"
                                    <?= $sort === 'oldest'
                                            ? 'selected'
                                            : ''; ?>
                            >
                                Oldest
                            </option>
                        </select>
                    </form>
                </div>

                <!-- NOTES -->
                <?php if (empty($notes)): ?>
                    <div class="empty">
                        <?php if (
                                $search !== ''
                                || $from !== ''
                                || $to !== ''
                        ): ?>
                            No notes found matching your filters.
                        <?php else: ?>

                            <?php if ($scope === 'global'): ?>
                                No global notes yet.
                            <?php else: ?>
                                You have no notes yet.
                            <?php endif; ?>

                        <?php endif; ?>
                    </div>
                <?php else: ?>


                    <!-- NOTE CARDS -->
                    <div class="row g-4">
                        <?php foreach ($notes as $note): ?>
                            <div class="col-12 col-md-6">
                                <div class="note-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="note-type <?= $note['is_global'] ? 'note-global' : 'note-private'; ?>">
                                            <?= $note['is_global'] ? 'Global' : 'Private'; ?>
                                        </div>
                                        <div class="note-creator <?= $note['user_id'] == $auth->id() ? 'note-owner' : ''; ?>">
                                            <?php if ($note['user_id'] == $auth->id()): ?>
                                                Your note
                                            <?php else: ?>
                                                <?= htmlspecialchars($note['creator_name']); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <h5 class="note-title">
                                        <?= htmlspecialchars(
                                                $note['title']
                                        ); ?>
                                    </h5>

                                    <div class="note-text mb-4">
                                        <?= htmlspecialchars(
                                                $note['content']
                                        ); ?>
                                    </div>

                                    <small class="note-meta d-block mb-3">
                                        Created:
                                        <?= date(
                                                'M j, Y \a\t H:i',
                                                strtotime(
                                                        $note['created_at']
                                                )
                                        ); ?>
                                    </small>

                                    <!-- ACTIONS -->
                                    <?php if ($note['user_id'] == $auth->id()): ?>
                                        <div class="d-flex gap-2">
                                            <!-- EDIT -->
                                            <button
                                                    type="button"
                                                    class="btn-note-edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editNoteModal<?= $note['id']; ?>"
                                            >
                                                Edit
                                            </button>

                                            <!-- DELETE -->
                                            <form
                                                    method="POST"
                                                    action="/notes/delete"
                                            >
                                                <input
                                                        type="hidden"
                                                        name="id"
                                                        value="<?= $note['id']; ?>"
                                                >
                                                <button
                                                        type="button"
                                                        class="btn-note-delete"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteNoteModal<?= $note['id']; ?>"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- EDIT MODALS -->
                    <?php include __DIR__ . "/../components/editNoteModal.php"; ?>

                    <!-- DELETE MODALS -->
                    <?php include __DIR__ . "/../components/deleteModal.php"; ?>

                    <!-- PAGINATION -->

                    <?php if ($totalPages > 1): ?>
                        <nav
                                class="mt-5"
                                aria-label="Notes pagination"
                        >
                            <ul
                                    class="pagination justify-content-center"
                            >

                                <!-- PREVIOUS -->
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a
                                                class="page-link pagination-link"
                                                href="/notes/search?scope=<?= urlencode($scope); ?>&notes_search=<?= urlencode($search); ?>&from=<?= urlencode($from); ?>&to=<?= urlencode($to); ?>&notes_sort=<?= urlencode($sort); ?>&notes_page=<?= $page - 1; ?>"
                                        >
                                            ← Previous
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <!-- PAGE NUMBERS -->
                                <?php for (
                                        $i = 1;
                                        $i <= $totalPages;
                                        $i++
                                ): ?>
                                    <li
                                            class="page-item <?= $i === $page
                                                    ? 'active'
                                                    : ''; ?>"
                                    >
                                        <a
                                                class="page-link pagination-link"
                                                href="/notes/search?scope=<?= urlencode($scope); ?>&notes_search=<?= urlencode($search); ?>&from=<?= urlencode($from); ?>&to=<?= urlencode($to); ?>&notes_sort=<?= urlencode($sort); ?>&notes_page=<?= $i; ?>"
                                        >
                                            <?= $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <!-- NEXT -->
                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item">

                                        <a
                                                class="page-link pagination-link"
                                                href="/notes/search?scope=<?= urlencode($scope); ?>&notes_search=<?= urlencode($search); ?>&from=<?= urlencode($from); ?>&to=<?= urlencode($to); ?>&notes_sort=<?= urlencode($sort); ?>&notes_page=<?= $page + 1; ?>"
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

<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>
</html>
