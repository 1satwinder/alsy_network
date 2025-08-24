@if($model->isUsed())
    <div class="btn btn-warning btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
@if($model->isBlocked())
    <div class="btn btn-dark btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
@if($model->isUnUsed())
    <div class="btn btn-success btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
