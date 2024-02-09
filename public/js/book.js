 $(document).ready(function () {
    $('#bookIndex').DataTable({
        dom: '<"top"fli>rt<"bottom"pB>',
        language: {
            lengthMenu: 'Show _MENU_',
            info: 'Displaying _START_-_END_ out of _TOTAL_',
            search: 'Search Books:',
        },
        buttons: [{
            extend: 'csv',
            text: 'Export Book List',
            exportOptions: { columns: [0, 1, 2, 3, 4] },
            title: 'Books'
        }],
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'All']
        ],
        columnDefs: [{
            targets: [5, 6, 7, 8],
            orderable: false,
            searchable: false,
        }]});

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
