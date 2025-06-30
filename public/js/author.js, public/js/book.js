$(document).ready(function () {
    // ... existing code ...
    $('#authorDeleted').DataTable({
        responsive: true,
        // ... existing code ...
        order: [[2, 'asc']]
    });

    // Handle the delete modal pop-up for authors
    $('#indexAuthor, #authorArchived').on('click', '.deleteCategoryBtn', function (e) {
        e.preventDefault();
        const authorId = $(this).val();
        $.ajax({
            url: `/author/check-delete/${authorId}`,
            type: 'GET',
            success: function (response) {
                const deleteModal = $('#deleteModal');
                // Set the form action dynamically
                deleteModal.find('form').attr('action', `/author/${authorId}`);
                deleteModal.find('#deleteQuestion').val(response.message);
                if (response.deletable) {
                    deleteModal.find('#confirmDeletionBtn').show();
                } else {
                    deleteModal.find('#confirmDeletionBtn').hide();
                }
                deleteModal.modal('show');
            },
            error: function () {
                alert('Error checking deletion status. Please try again.');
            }
        });
    });

    // Handle the archive modal pop-up for authors
    $('#indexAuthor').on('click', '.archiveCategoryBtn', function (e) {
        e.preventDefault();
        const authorId = $(this).val();
        $.ajax({
            url: `/author/check-archive/${authorId}`,
            type: 'GET',
            success: function (response) {
                const archiveModal = $('#archiveModal');
                // Set the form action dynamically
                archiveModal.find('form').attr('action', `/author/archive/${authorId}`);
                archiveModal.find('#archiveQuestion').val(response.message);
                archiveModal.modal('show');
            },
            error: function () {
                alert('Error checking archive status. Please try again.');
            }
        });
    });

    // Handle the delete modal pop-up for books
    $('#bookIndex').on('click', '.deleteCategoryBtn', function (e) {
        e.preventDefault();
        const bookId = $(this).val();
        $.ajax({
            url: `/book/check-delete/${bookId}`,
            type: 'GET',
            success: function (response) {
                const deleteModal = $('#deleteModal');
                // Set the form action dynamically
                deleteModal.find('form').attr('action', `/book/${bookId}`);
                deleteModal.find('#deleteQuestion').val(response.message);
                if (response.deletable) {
                    deleteModal.find('#confirmDeletionBtn').show();
                } else {
                    deleteModal.find('#confirmDeletionBtn').hide();
                }
                deleteModal.modal('show');
            },
            error: function () {
                alert('Error checking deletion status. Please try again.');
            }
        });
    });

    // Handle the archive modal pop-up for books
    $('#bookIndex').on('click', '.archiveCategoryBtn', function (e) {
        e.preventDefault();
        const bookId = $(this).val();
        $.ajax({
            url: `/book/check-archive/${bookId}`,
            type: 'GET',
            success: function (response) {
                const archiveModal = $('#archiveModal');
                // Set the form action dynamically
                archiveModal.find('form').attr('action', `/book/archive/${bookId}`);
                archiveModal.find('#archiveQuestion').val(response.message);
                archiveModal.modal('show');
            },
            error: function () {
                alert('Error checking archive status. Please try again.');
            }
        });
    });
}); 