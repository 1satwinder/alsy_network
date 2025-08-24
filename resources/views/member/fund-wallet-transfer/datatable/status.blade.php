@if($model->status == \App\Models\FundRequest::STATUS_PENDING)
    <span class="btn btn-sm btn-warning">
        {{ \App\Models\FundRequest::STATUSES[$model->status] }}
    </span>
@endif
@if($model->status == \App\Models\FundRequest::STATUS_APPROVED)
    <span class="btn btn-sm btn-success">
        {{ \App\Models\FundRequest::STATUSES[$model->status] }}
    </span>
@endif
@if($model->status == \App\Models\FundRequest::STATUS_REJECTED)
    <span class="btn btn-sm btn-danger">
        {{ \App\Models\FundRequest::STATUSES[$model->status] }}
    </span>
@endif
