<?php foreach ($notes as $note): ?>
    <div
        class="modal fade"
        id="editNoteModal<?= $note['id']; ?>"
        tabindex="-1"
        aria-labelledby="editNoteModalLabel<?= $note['id']; ?>"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content dark-modal">
                <!-- HEADER -->
                <div class="modal-header">
                    <h5
                        class="modal-title"
                        id="editNoteModalLabel<?= $note['id']; ?>"
                    >
                        Edit Note
                    </h5>

                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <!-- FORM -->
                <form
                    method="POST"
                    action="/notes/update"
                >
                    <div class="modal-body">
                        <input
                            type="hidden"
                            name="id"
                            value="<?= $note['id']; ?>"
                        >

                        <!-- TITLE -->
                        <div class="mb-3">
                            <label
                                for="updated_title_<?= $note['id']; ?>"
                                class="form-label"
                            >
                                Title
                            </label>
                            <input
                                type="text"
                                id="updated_title_<?= $note['id']; ?>"
                                name="updated_title"
                                class="form-control modal-input"
                                value="<?= htmlspecialchars(
                                    $note['title']
                                ); ?>"
                                maxlength="30"
                                required
                            >
                        </div>

                        <!-- CONTENT -->
                        <div class="mb-3">
                            <label
                                for="updated_note_<?= $note['id']; ?>"
                                class="form-label"
                            >
                                Content
                            </label>

                            <textarea
                                id="updated_note_<?= $note['id']; ?>"
                                name="updated_note"
                                class="form-control modal-input"
                                rows="5"
                                maxlength="300"
                                required
                            ><?= htmlspecialchars(
                                    $note['content']
                                ); ?></textarea>

                        </div>
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
                        <button
                            type="submit"
                            class="btn-modal-save"
                        >
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>