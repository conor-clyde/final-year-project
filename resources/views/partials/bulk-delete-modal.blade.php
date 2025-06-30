<!-- delete-modal.blade.php -->

<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="bulkDeleteForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkDeleteModalLabel">Bulk Delete Genres</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="genre_ids" id="bulk_delete_genre_ids">
                    <div id="bulkDeleteError" class="alert alert-danger d-none" role="alert"></div>
                    <div id="bulkDeleteQuestion" class="mb-2">Are you sure you want to delete the selected genres?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</button>
                    <button id="confirmBulkDeleteBtn" type="submit" class="btn btn-danger">Confirm Deletion</button>
                </div>
            </form>
        </div>
    </div>
</div>
