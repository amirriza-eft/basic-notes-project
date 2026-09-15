<?php foreach ($notes as $note): ?>
    <div
        class="modal fade"
        id="deleteNoteModal<?= $note['id']; ?>"
        tabindex="-1"
        aria-labelledby="deleteNoteModalLabel<?= $note['id']; ?>"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content dark-modal">
                <!-- HEADER -->
                <div class="modal-header">
                    <h5
                        class="modal-title"
                        id="deleteNoteModalLabel<?= $note['id']; ?>"
                    >
                        Delete Note
                    </h5>
                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">
                    <p class="mb-0">
                        Are you sure you want to delete this note?
                    </p>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn-modal-cancel"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>
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
                            type="submit"
                            class="btn-note-delete"
                        >
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>