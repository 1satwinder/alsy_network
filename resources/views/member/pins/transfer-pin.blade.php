<form action="{{ route('member.pin-transfers.store') }}" method="post" id="pinTransferForm">
    @csrf

    <button type="button" class="btn btn-primary ms-3 mt-2"
            data-bs-toggle="modal" data-bs-target="#large-modal" id="transferPinButton" disabled>
        Transfer PIN
    </button>

    <div id="large-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Transfer To</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="code" name="code" class="form-control memberCodeInput"
                                   placeholder="Enter Member ID" required>
                            <label for="code" class="required">
                                Member ID
                            </label>
                        </div>
                        <h4 id="error_code" class="text-danger"></h4>
                        <h4 id="member_name" class="text-primary"></h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="btn_transfer">
                        Transfer Pins
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@push('page-javascript')
    <script>
        $(document).ready(function () {
            $('#transferPinButton').css('cursor', 'not-allowed');
        });
        $('body').on('change', '.pinCheckBox', function () {
            if ($('.pinCheckBox:checked').length > 0) {
                $('#transferPinButton').prop('disabled', false);
                $('#transferPinButton').css('cursor', 'pointer');
            } else {
                $('#transferPinButton').css('cursor', 'not-allowed');
                $('#transferPinButton').prop('disabled', true);
            }
        });
    </script>
@endpush
