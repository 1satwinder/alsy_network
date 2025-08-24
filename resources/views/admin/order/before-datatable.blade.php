<div class="row mb-4">
    <div class="col-xl-2 col-6">
        <a href="javascript:void(0)">
            <div class="p-2 text-center">
                <h3><span data-plugin="counterup">{{$placed}}</span></h3>
                <p class="text-muted font-15 mb-0">Placed</p>
            </div>
        </a>
    </div>
    <div class="col-xl-2 col-6">
        <a href="javascript:void(0)">
            <div class="p-2 text-center">
                <h3><span data-plugin="counterup">{{$confirm}}</span></h3>
                <p class="text-muted font-15 mb-0">Confirmed</p>
            </div>
        </a>
    </div>
    <div class="col-xl-2 col-6">
        <a href="javascript:void(0)">
            <div class="p-2 text-center">
                <h3><span data-plugin="counterup">{{$manifest}}</span></h3>
                <p class="text-muted font-15 mb-0">Manifested</p>
            </div>
        </a>
    </div>
    <div class="col-xl-2 col-6">
        <a href="javascript:void(0)">
            <div class="p-2 text-center">
                <h3><span data-plugin="counterup">{{$dispatch}}</span></h3>
                <p class="text-muted font-15 mb-0">Dispatch</p>
            </div>
        </a>
    </div>
    <div class="col-xl-2 col-6">
        <a href="javascript:void(0)">
            <div class="p-2 text-center">
                <h3><span data-plugin="counterup">{{$deliver}}</span></h3>
                <p class="text-muted font-15 mb-0">Delivered</p>
            </div>
        </a>
    </div>
    <div class="col-xl-2 col-6">
        <a href="javascript:void(0)">
            <div class="p-2 text-center">
                <h3><span data-plugin="counterup">{{$replace}}</span></h3>
                <p class="text-muted font-15 mb-0">Replace</p>
            </div>
        </a>
    </div>
</div>

<form action="{{ route('admin.orders.bulk-status-update') }}" method="post" id="statusChangeForm">
    @csrf
    <div class="row">
        <div class="form-group col-sm-6 col-md-3 col-lg-2 mb-3">
            <div class="form-floating form-floating-outline">
                <select name="status" id="statusP" class="form-control" data-toggle="select2"
                        required>
                    <option value="">Select Package</option>
                    @foreach($statuses as $value => $name)
                        <option value="{{ $value }}">{{ $name }}</option>
                    @endforeach
                </select>
                <label for="statusP" class="required">Select</label>
            </div>
        </div>
        <div class="form-group col-sm-6 col-md-3 col-lg-2">
            <div class="form-floating form-floating-outline">
                <input type="text" is="remarks" name="remarks" class="form-control" placeholder="Enter Remarks" required>
                <label class="required" for="remarks">Remarks</label>
            </div>
        </div>
        <div class="form-group col-4">
            <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light" disabled
                    data-toggle="modal" data-target="#large-modal" id="transferPinButton">
                Submit
            </button>
        </div>
    </div>
</form>

@push('page-javascript')
    @include('admin.partials.checkbox-script')
@endpush
