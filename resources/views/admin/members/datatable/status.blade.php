@if($model->isFree())
    <div class="btn btn-danger btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
@if($model->isActive())
    <div class="btn btn-success btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
@if($model->isBlocked())
    <div class="btn btn-dark btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
