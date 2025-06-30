$(document).ready(function () {
    $('#bookIndex').DataTable({
        responsive: true,
        dom: '<"top"fli>rt<"bottom"pB>',
        language: {
            lengthMenu: 'Show _MENU_',
            info: 'Displaying _START_-_END_ out of _TOTAL_',
            search: 'Search Books:',
        },
        lengthMenu: [
            [10, 25, 50, 100],
            ['10', '25', '50', '100']
        ],
        columnDefs: [
            {
                targets: [7],
                orderable: false,
                searchable: false
            },
            {
                targets: [1, 5, 6],
                searchable: false
            }
        ],
        order: [[2, 'asc']]
    });
   
    // The styling code below is temporarily commented out for debugging.
    /*
    var wrapper = $('.dataTables_wrapper');
    var filter = wrapper.find('.dataTables_filter');
    var searchInput = filter.find('input');
    var lengthMenu = wrapper.find('.dataTables_length');
    var paginationContainer = $('.dataTables_paginate');
    var filter = wrapper.find('.dataTables_filter');

    filter.css('float', 'left');
    lengthMenu.css('float', 'right');
    searchInput.css({
        'margin-left': '20px',
        'width': '340px'
    });
    paginationContainer.addClass('float-start');
    */

    // Handle the delete modal pop-up for books
    $('#bookIndex').on('click', '.deleteCategoryBtn', function (e) {
        e.preventDefault();
        const bookId = $(this).val();
        $.ajax({
            url: `/book/check-delete/${bookId}`,
            type: 'GET',
            success: function (response) {
                const deleteModal = $('#deleteModal');
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
                archiveModal.find('form').attr('action', `/book/archive/${bookId}`);
                archiveModal.find('#archiveQuestion').text(response.message);
                archiveModal.modal('show');
            },
            error: function () {
                alert('Error checking archive status. Please try again.');
            }
        });
    });
})
    ;



