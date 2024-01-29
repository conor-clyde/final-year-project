// resources/views/js/custom.js

function showDeleteConfirmation(genreId) {
    // Update the modal's content and show it
    $('#deleteConfirmationModal').modal('show');

    // Attach the genreId to the "Delete" button in the modal
    $('#deleteConfirmationModal').find('.confirm-delete-btn').data('genre-id', genreId);
}

function confirmDelete() {
    // Retrieve the genreId from the "Delete" button in the modal
    var genreId = $('#deleteConfirmationModal').find('.confirm-delete-btn').data('genre-id');

    // Redirect to the delete route with the genreId
    window.location.href = '/genres/' + genreId + '/delete';
}
