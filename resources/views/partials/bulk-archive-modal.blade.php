<!-- archive-modal.blade.php -->

<div class="modal fade" id="bulkArchiveModal" tabindex="-1" aria-labelledby="bulkArchiveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkArchiveModalLabel">Bulk Archive Genres</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bulkArchiveForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="genre_ids" id="bulk_archive_genre_ids">
                    <div id="bulkArchiveError" class="alert alert-danger d-none" role="alert"></div>
                    <div id="bulkArchiveQuestion" class="mb-2">Are you sure you want to archive the selected genres?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="confirmBulkArchiveBtn" class="btn btn-primary">Confirm Archive</button>
                </div>
            </form>
        </div>
    </div>
</div>





