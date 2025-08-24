@if($model->status == \App\Models\PinRequest::STATUS_PENDING)
    <span class="btn btn-sm btn-warning"> Pending</span>
@endif

@if($model->status == \App\Models\PinRequest::STATUS_APPROVED)
    <span class="btn btn-sm btn-success"> Approved</span>
@endif

@if($model->status == \App\Models\PinRequest::STATUS_REJECTED)
    <span class="btn btn-sm btn-danger"> Rejected</span>
@endif
