<div
    class="modal fade"
    id="addNoteModal"
    tabindex="-1"
    aria-labelledby="addNoteModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content dark-modal">

            <!-- MODAL HEADER -->
            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="addNoteModalLabel"
                >
                    Add Note
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
                action="/notes/create"
            >
                <div class="modal-body">

                    <!-- TITLE -->
                    <div class="mb-3">
                        <label
                            for="note_title"
                            class="form-label"
                        >
                            Title
                        </label>
                        <input
                            type="text"
                            id="note_title"
                            name="note_title"
                            class="form-control modal-input"
                            placeholder="Note title..."
                            maxlength="30"
                            required
                        >
                    </div>

                    <!-- CONTENT -->
                    <div class="mb-3">
                        <label
                            for="note"
                            class="form-label"
                        >
                            Content
                        </label>
                        <textarea
                            id="note"
                            name="note"
                            class="form-control modal-input"
                            rows="5"
                            maxlength="300"
                            placeholder="Write your note here..."
                            required
                        ></textarea>
                    </div>

                    <!-- GLOBAL -->
                    <div class="form-check">
                        <input
                            type="checkbox"
                            id="is_global"
                            name="is_global"
                            value="1"
                            class="form-check-input"
                        >
                        <label
                            for="is_global"
                            class="form-check-label"
                        >
                            Make this note global
                        </label>
                    </div>
                </div>

                <!-- MODAL FOOTER -->
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
                        Add Note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>