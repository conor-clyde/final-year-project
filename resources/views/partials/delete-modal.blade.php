<!-- delete-modal.blade.php -->

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ url('genre/delete') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Genre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="genre_id" id="category_id">
                    <textarea style="border: none; border-color: transparent; width:100%; resize: none;" readonly id="deleteQuestion" cols="50" rows="2"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</button>
                    <button id="confirmDeletionBtn" type="submit" class="btn btn-danger">Confirm Deletion</button>
                </div>
            </form>
        </div>
    </div>
</div>
