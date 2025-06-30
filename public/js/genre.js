// Create genre.index datatable
$(document).ready(function () {

    const setupModal = (buttonClass, modalId, checkUrl, formActionUrl, idPlaceholder) => {
        $('body').on('click', buttonClass, function (e) {
            e.preventDefault();
            const itemId = $(this).val();
            $.ajax({
                url: checkUrl.replace(idPlaceholder, itemId),
                type: 'GET',
                success: function (response) {
                    const modal = $(modalId);
                    modal.find('form').attr('action', formActionUrl.replace(idPlaceholder, itemId));
                    // Set the value of the textarea for archive modal
                    if (modalId === '#archiveModal') {
                        modal.find('#archiveQuestion').val(response.message);
                    } else {
                        const deleteQuestion = modal.find('#deleteQuestion');
                        const notAllowedAlert = modal.find('#deleteNotAllowedAlert');
                        if (response.deletable === false) {
                            notAllowedAlert.removeClass('d-none').text(
                                'This genre cannot be deleted because it is currently assigned to one or more books. To delete this genre, please remove all books associated with it first.'
                            );
                            deleteQuestion.text('');
                            modal.find('.modal-footer .btn-danger').hide();
                        } else {
                            if (deleteQuestion.length) {
                                if (deleteQuestion.is('textarea')) {
                                    deleteQuestion.val(response.message);
                                } else {
                                    deleteQuestion.text(response.message);
                                }
                            }
                            notAllowedAlert.addClass('d-none').text('');
                            modal.find('.modal-footer .btn-danger').show();
                        }
                    }
                    $(modalId).modal('show');
                },
                error: function () {
                    alert('Error performing check. Please try again.');
                }
            });
        });
    };

    setupModal('.archiveCategoryBtn', '#archiveModal', '/genre/check-archive/ID', '/genre/archive/ID', 'ID');
    setupModal('.deleteCategoryBtn', '#deleteModal', '/genre/check-delete/ID', '/genre/ID', 'ID');

    // DataTable options without export/colvis buttons
    function getGenreTableOptions(orderCol = 1) {
        return {
            responsive: true,
            dom: '<"top d-flex justify-content-end"l>t<"bottom"ip>',
        
            language: {
                search: 'Search:',
                lengthMenu: 'Show _MENU_',
                info: 'Showing _START_-_END_ of _TOTAL_',
            },
            order: [[orderCol, 'asc']],
            columnDefs: [
                {
                    targets: [4],
                    orderable: false,
                    searchable: false
                },
                {
                    targets: [3],
                    searchable: false
                }
            ],
        };
    }

    $('#genreIndex').DataTable(getGenreTableOptions(1));
    $('#genreArchived').DataTable(getGenreTableOptions(1));
    $('#genreDeleted').DataTable(getGenreTableOptions(1));

    // Move the DataTables length dropdown to the custom container
    $('#genreIndex_length').appendTo('#lengthDropdownContainer');

    // Accessibility: Focus confirm button when modals open
    $('#archiveModal').on('shown.bs.modal', function () {
        $('#confirmArchiveBtn').trigger('focus');
    });
    $('#deleteModal').on('shown.bs.modal', function () {
        $('#confirmDeletionBtn').trigger('focus');
    });

    // Tooltip initialization (consistent placement and accessibility)
    function initTooltips() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl, {
                placement: 'top',
                trigger: 'hover focus',
                customClass: 'genre-tooltip',
                boundary: 'window',
                container: 'body',
                delay: { show: 200, hide: 100 }
            });
            // Add aria-describedby for accessibility
            if (!tooltipTriggerEl.getAttribute('aria-describedby')) {
                tooltipTriggerEl.setAttribute('aria-describedby', tooltipTriggerEl.getAttribute('title'));
            }
        });
    }
    initTooltips();
    // Re-initialize tooltips after DataTable redraw
    $('#genreIndex, #genreArchived, #genreDeleted').on('draw.dt', function () {
        initTooltips();
    });

    // --- Bulk Actions Logic ---
    function updateBulkButtons() {
        const checked = $('.genreCheckbox:checked').length;
        if (checked > 0) {
            $('#bulkArchiveBtn, #bulkDeleteBtn').removeClass('d-none').prop('disabled', false);
        } else {
            $('#bulkArchiveBtn, #bulkDeleteBtn').addClass('d-none').prop('disabled', true);
        }
    }
    $(document).on('change', '.genreCheckbox', updateBulkButtons);
    $('#selectAllGenres').on('change', function () {
        $('.genreCheckbox').prop('checked', this.checked);
        updateBulkButtons();
    });

    // Open bulk modals with selected IDs
    $('#bulkArchiveBtn').on('click', function () {
        const ids = $('.genreCheckbox:checked').map(function () { return this.value; }).get().join(',');
        $('#bulk_archive_genre_ids').val(ids);
        $('#bulkArchiveError').addClass('d-none').text('');
    });
    $('#bulkDeleteBtn').on('click', function () {
        const ids = $('.genreCheckbox:checked').map(function () { return this.value; }).get().join(',');
        $('#bulk_delete_genre_ids').val(ids);
        $('#bulkDeleteError').addClass('d-none').text('');
    });

    // AJAX for bulk archive
    $('#bulkArchiveForm').on('submit', function (e) {
        e.preventDefault();
        const ids = $('#bulk_archive_genre_ids').val();
        const btn = $('#confirmBulkArchiveBtn');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Archiving...');
        $.ajax({
            url: '/genre/bulk-archive',
            method: 'POST',
            data: { genre_ids: ids, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                location.reload();
            },
            error: function (xhr) {
                $('#bulkArchiveError').removeClass('d-none').text(xhr.responseJSON?.message || 'Bulk archive failed.');
                btn.prop('disabled', false).text('Confirm Archive');
                console.error('Bulk archive error:', xhr);
            }
        });
    });
    // AJAX for bulk delete
    $('#bulkDeleteForm').on('submit', function (e) {
        e.preventDefault();
        const ids = $('#bulk_delete_genre_ids').val();
        const btn = $('#confirmBulkDeleteBtn');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Deleting...');
        $.ajax({
            url: '/genre/bulk-delete',
            method: 'POST',
            data: { genre_ids: ids, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                location.reload();
            },
            error: function (xhr) {
                $('#bulkDeleteError').removeClass('d-none').text(xhr.responseJSON?.message || 'Bulk delete failed.');
                btn.prop('disabled', false).text('Confirm Deletion');
                console.error('Bulk delete error:', xhr);
            }
        });
    });

    // --- Client-side Validation for Genre Forms ---
    $(document).on('submit', 'form[action*="genre"]', function (e) {
        const name = $(this).find('input[name="name"]');
        if (name.length && (!name.val() || name.val().length > 255)) {
            e.preventDefault();
            name.addClass('is-invalid');
            if (!name.next('.invalid-feedback').length) {
                name.after('<div class="invalid-feedback">Genre name is required and must be under 255 characters.</div>');
            }
            name.focus();
        }
        const desc = $(this).find('textarea[name="description"]');
        if (desc.length && desc.val().length > 255) {
            e.preventDefault();
            desc.addClass('is-invalid');
            if (!desc.next('.invalid-feedback').length) {
                desc.after('<div class="invalid-feedback">Description must be under 255 characters.</div>');
            }
            desc.focus();
        }
    });

    // --- Toast Notifications ---
    function showToast(message, type = 'success') {
        const toast = $(
            `<div class="toast align-items-center text-bg-${type} border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" style="z-index:9999;">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`
        );
        $('body').append(toast);
        const bsToast = new bootstrap.Toast(toast[0], { delay: 3500 });
        bsToast.show();
        toast.on('hidden.bs.toast', function () { toast.remove(); });
    }
    // Example: showToast('Genres archived!', 'success');

    // --- Modal Error Handling for Single Archive/Delete ---
    function handleModalError(modalId, errorMsg) {
        const errorDiv = $(modalId).find('.modal-error');
        if (errorDiv.length) {
            errorDiv.removeClass('d-none').text(errorMsg);
        } else {
            $(modalId).find('.modal-body').prepend(`<div class="alert alert-danger modal-error">${errorMsg}</div>`);
        }
    }
    function clearModalError(modalId) {
        $(modalId).find('.modal-error').addClass('d-none').text('');
    }

    // Example AJAX for single delete (adapt for your actual implementation)
    $(document).on('submit', '#deleteModal form', function (e) {
        e.preventDefault();
        clearModalError('#deleteModal');
        const btn = $('#confirmDeletionBtn');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Deleting...');
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                showToast('Genre deleted!', 'success');
                location.reload();
            },
            error: function (xhr) {
                handleModalError('#deleteModal', xhr.responseJSON?.message || 'Delete failed.');
                btn.prop('disabled', false).text('Confirm Deletion');
                console.error('Delete error:', xhr);
            }
        });
    });
    // Example AJAX for single archive (adapt for your actual implementation)
    $(document).on('submit', '#archiveModal form', function (e) {
        e.preventDefault();
        clearModalError('#archiveModal');
        const btn = $('#confirmArchiveBtn');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Archiving...');
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                showToast('Genre archived!', 'success');
                location.reload();
            },
            error: function (xhr) {
                handleModalError('#archiveModal', xhr.responseJSON?.message || 'Archive failed.');
                btn.prop('disabled', false).text('Confirm Archive');
                console.error('Archive error:', xhr);
            }
        });
    });
    // Focus confirm button on modal open (already present, but ensure for DRYness)
    $('#archiveModal').on('shown.bs.modal', function () {
        $('#confirmArchiveBtn').trigger('focus');
        clearModalError('#archiveModal');
    });
    $('#deleteModal').on('shown.bs.modal', function () {
        $('#confirmDeletionBtn').trigger('focus');
        clearModalError('#deleteModal');
    });

    // --- Custom Search Bar for Genres Table ---
    $('#genreSearch').on('keyup input', function () {
        $('#genreIndex').DataTable().search(this.value).draw();
    });
});
