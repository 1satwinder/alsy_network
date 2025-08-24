@if($model->isNotApplied())
    <div class="btn btn-primary btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
@if($model->isPending())
    <div class="btn btn-warning btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
@if($model->isApproved())
    <div class="btn btn-success btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
@if($model->isRejected())
    <div class="btn btn-danger btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
