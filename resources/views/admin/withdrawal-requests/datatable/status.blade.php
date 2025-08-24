@if($model->status == \App\Models\WithdrawalRequest::STATUS_PENDING)
    <span class="btn btn-warning btn-sm waves-effect waves-light">
    {{ \App\Models\WithdrawalRequest::STATUSES[$model->status] }}
</span>
@endif

@if($model->status == \App\Models\WithdrawalRequest::STATUS_APPROVED)
    <span class="btn btn-success btn-sm waves-effect waves-light">
    {{ \App\Models\WithdrawalRequest::STATUSES[$model->status] }}
</span>
@endif

@if($model->status == \App\Models\WithdrawalRequest::STATUS_REJECTED)
    <span class="btn btn-danger btn-sm waves-effect waves-light">
    {{ \App\Models\WithdrawalRequest::STATUSES[$model->status] }}
</span>
@endif

