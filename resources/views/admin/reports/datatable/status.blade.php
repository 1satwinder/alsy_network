@if($model->status == \App\Models\RewardBonusIncome::STATUS_ACHIEVED)
    <div class="btn btn-success btn-sm">
        {{ \App\Models\RewardBonusIncome::STATUSES[$model->status] }}
    </div>
@else
    <div class="btn btn-danger btn-sm">
        {{ \App\Models\RewardBonusIncome::STATUSES[$model->status] }}
    </div>
@endif
