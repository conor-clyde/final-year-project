<!-- archive-modal.blade.php -->

<div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary bg-opacity-10 border-0">
                <h5 class="modal-title text-secondary d-flex align-items-center" id="archiveModalLabel">
                    <i class="bi bi-archive me-2 text-secondary"></i> {{ __('Archive') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <form id="archiveForm" action="{{ $formAction ?? '' }}" method="POST" role="form">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="archive_id">
                    <div id="archiveQuestion" class="form-control-plaintext mb-2 text-secondary-emphasis" style="white-space:pre-line;"></div>
                    <div class="alert alert-secondary mt-2 mb-0" role="alert">
                        {{ __('Are you sure you want to archive this item? You can restore it later from the archived list.') }}
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" id="confirmArchiveBtn" class="btn btn-secondary">{{ __('Confirm Archive') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>





