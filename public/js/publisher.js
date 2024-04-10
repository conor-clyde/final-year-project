// Create genre.index datatable
$(document).ready(function () {
    $('#publisherIndex').DataTable({
        dom: '<"top"fli>rt<"bottom"pB>',
        language: {
            lengthMenu: 'Show _MENU_',
            info: 'Displaying _START_-_END_ out of _TOTAL_',
            search: 'Search Publishers:',
        },
        buttons: [{
            extend: 'csv',
            text: 'Export Publisher List',
            exportOptions: {columns: [0, 1]},
            title: 'Publishers'
        }],
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'All']
        ],
        columnDefs: [{
            targets: [3, 4, 5, 6],
            orderable: false,
            searchable: false,
        },
            {
                targets: [2],
                searchable: false,
            }],

        order: [[1, 'asc']]
    });

    <!-- Styles-->
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
});


