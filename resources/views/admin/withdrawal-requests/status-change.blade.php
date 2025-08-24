<form action="{{ route('admin.withdrawal-requests.status-update') }}" method="post" id="statusChangeForm">
    @csrf
    <div class="row">
        <div class="form-group col-md-3 col-8">
            <label>Status</label>
            <select name="changeStatus" class="form-control" data-toggle="select2" required>
                <option value="">Select Status</option>
                <option value="{{\App\Models\WithdrawalRequest::STATUS_APPROVED}}"> Approve</option>
                <option value="{{\App\Models\WithdrawalRequest::STATUS_REJECTED}}"> Reject</option>
            </select>
        </div>
        <div class="form-group col-md-3 col-4">
            <label for="">&nbsp;</label><br>
            <button type="submit" class="btn btn-primary waves-effect waves-light" id="disableButton" disabled>
                Submit
            </button>
        </div>
    </div>
</form>

@push('page-javascript')
    @include('admin.partials.checkbox-script')
@endpush
