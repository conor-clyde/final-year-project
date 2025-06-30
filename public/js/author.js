$(document).ready(function () {
    // Common DataTable options
    const dataTableOptions = {
        responsive: true,
        dom: '<"top"fli>rt<"bottom"pB>',
        language: {
            lengthMenu: 'Show _MENU_',
            info: 'Displaying _START_-_END_ out of _TOTAL_',
            search: 'Search Authors:',
        },
        lengthMenu: [ [10, 25, 50, -1], ['10', '25', '50', 'All'] ],
        columnDefs: [{ targets: [4], orderable: false, searchable: false }],
        order: [[2, 'asc']]
    };

    // DataTable for the main author index page
    $('#authorIndex').DataTable(dataTableOptions);

    // DataTable for the archived authors page
    $('#authorArchived').DataTable(dataTableOptions);

    // DataTable for the deleted authors page
    $('#authorDeleted').DataTable(dataTableOptions);

    // Handle the delete modal pop-up for authors
    $('.card-body').on('click', '.deleteCategoryBtn', function (e) {
        e.preventDefault();
        const authorId = $(this).val();
        $.ajax({
            url: `/author/check-delete/${authorId}`,
            type: 'GET',
            success: function (response) {
                const deleteModal = $('#deleteModal');
                deleteModal.find('form').attr('action', `/author/${authorId}`);
                deleteModal.find('#deleteQuestion').val(response.message);
                if (response.deletable) {
                    deleteModal.find('#confirmDeletionBtn').show();
                } else {
                    deleteModal.find('#confirmDeletionBtn').hide();
                }
                deleteModal.modal('show');
            },
            error: function () { alert('Error checking deletion status. Please try again.'); }
        });
    });

    // Handle the archive modal pop-up for authors
    $('#authorIndex').on('click', '.archiveCategoryBtn', function (e) {
        e.preventDefault();
        const authorId = $(this).val();
        $.ajax({
            url: `/author/check-archive/${authorId}`,
            type: 'GET',
            success: function (response) {
                const archiveModal = $('#archiveModal');
                // Set the form's action attribute, not the button's href
                archiveModal.find('form').attr('action', `/author/archive/${authorId}`);
                // Set the text of the paragraph element
                archiveModal.find('#archiveQuestion').text(response.message);
                archiveModal.modal('show');
            },
            error: function () { alert('Error checking archive status. Please try again.'); }
        });
    });
});
