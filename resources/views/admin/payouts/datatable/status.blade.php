@if($model->isPending())
    <div class="btn btn-warning btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
@if($model->isCompleted())
    <div class="btn btn-success btn-sm">
        {{ $model->present()->status() }}
    </div>
@endif
