<form action="{{ route('admin.categories.status-update') }}" method="post" id="statusChangeForm">
    @csrf
    <div class="row">
        <div class="form-group col-md-3 col-8">
            <div class="form-floating form-floating-outline">
                <select name="changeStatus" id="statusP" class="form-control" data-toggle="select2"
                        required>
                    <option value="">Select Status</option>
                    <option value="{{\App\Models\Category::STATUS_ACTIVE}}"> Active</option>
                    <option value="{{\App\Models\Category::STATUS_INACTIVE}}"> In-Active</option>
                </select>
                <label for="statusP" class="required">Select Status</label>
            </div>
        </div>

        <div class="form-group col-md-3 col-4">
            <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light" id="disableButton" disabled>
                Submit
            </button>
        </div>
    </div>
</form>

@push('page-javascript')
    @include('admin.partials.checkbox-script')
@endpush
