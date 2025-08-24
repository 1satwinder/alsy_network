@if($model->status == \App\Models\News::STATUS_ACTIVE)
    <span class="btn btn-success btn-sm waves-effect waves-light"> {{ \App\Models\News::STATUSES[$model->status] }} </span>
@endif
@if($model->status == \App\Models\News::STATUS_INACTIVE)
    <span class="btn btn-danger btn-sm waves-effect waves-light"> {{ \App\Models\News::STATUSES[$model->status] }} </span>
@endif
