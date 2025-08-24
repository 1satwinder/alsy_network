@if($model->isPending())
    <span class="btn btn-sm btn btn-warning">
        {{ $model->present()->status() }}
    </span>
@endif
@if($model->isApproved())
    <span class="btn btn-sm btn btn-success">
        {{ $model->present()->status() }}
    </span>
@endif
@if($model->isRejected())
    <span class="btn btn-sm btn btn-danger">
        {{ $model->present()->status() }}
    </span>
@endif
