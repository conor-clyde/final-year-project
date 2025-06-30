<!-- delete-modal.blade.php -->

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ $formAction ?? '' }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger bg-opacity-10 border-0">
                    <h5 class="modal-title text-danger d-flex align-items-center" id="deleteModalLabel">
                        <i class="bi bi-trash me-2"></i> Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="category_id">
                    <div id="deleteQuestion" class="form-control-plaintext mb-2 text-danger-emphasis" style="white-space:pre-line;"></div>
                    <div class="alert alert-warning mt-2 mb-0 d-none" role="alert" id="deleteNotAllowedAlert"></div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</button>
                    <button id="confirmDeletionBtn" type="submit" class="btn btn-danger">Confirm Deletion</button>
                </div>
            </form>
        </div>
    </div>
</div>
