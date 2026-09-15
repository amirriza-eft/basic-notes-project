<div
    class="modal fade"
    id="searchModal"
    tabindex="-1"
    aria-labelledby="searchModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content dark-modal">

            <!-- HEADER -->
            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="searchModalLabel"
                >
                    Search Notes
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
                method="GET"
                action="/notes/search"
            >
                <div class="modal-body">
                    <!-- SEARCH -->
                    <div class="mb-3">
                        <label
                            for="notes_search"
                            class="form-label"
                        >
                            Search
                        </label>
                        <input
                            type="text"
                            id="notes_search"
                            name="notes_search"
                            class="form-control modal-input"
                            placeholder="Search title or content..."
                            value="<?= htmlspecialchars($search); ?>"
                        >
                    </div>

                    <!-- DATES -->
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label
                                for="from"
                                class="form-label"
                            >
                                From
                            </label>
                            <input
                                type="date"
                                id="from"
                                name="from"
                                class="form-control modal-input"
                                value="<?= htmlspecialchars($from); ?>"
                            >
                        </div>

                        <div class="col-12 col-md-6">
                            <label
                                for="to"
                                class="form-label"
                            >
                                To
                            </label>
                            <input
                                type="date"
                                id="to"
                                name="to"
                                class="form-control modal-input"
                                value="<?= htmlspecialchars($to); ?>"
                            >
                        </div>
                    </div>
                    <input
                        type="hidden"
                        name="scope"
                        value="<?= htmlspecialchars($scope); ?>"
                    >
                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <a
                        href="/"
                        class="btn-modal-cancel"
                    >
                        Clear
                    </a>
                    <button
                        type="submit"
                        class="btn-modal-save"
                    >
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>