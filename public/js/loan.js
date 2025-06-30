$(document).ready(function () {
    $('#indexLoan').DataTable({
        dom: '<"top"fli>rt<"bottom"pB>',
        language: {
            lengthMenu: 'Show _MENU_',
            info: 'Displaying _START_-_END_ out of _TOTAL_',
            search: 'Search Loans:',
        },
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'All']
        ],
        columnDefs: [{
            targets: [3, 4],
            orderable: false,
        },
            {
            targets: [5, 6, 7],
            orderable: false,
            searchable: false,
        }],
        order: [[0, 'desc']]
    });

    var wrapper = $('.dataTables_wrapper');
    var filter = wrapper.find('.dataTables_filter');
    var searchInput = filter.find('input');
    var lengthMenu = wrapper.find('.dataTables_length');
    var paginationContainer = $('.dataTables_paginate');
    filter = wrapper.find('.dataTables_filter');

    filter.css('float', 'left');
    lengthMenu.css('float', 'right');
    searchInput.css({
        'margin-left': '20px',
        'width': '340px'
    });
    paginationContainer.addClass('float-start');
});
