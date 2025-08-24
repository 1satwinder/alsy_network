@if($model->status == \App\Models\Order::STATUS_PENDING)
    <h5><span class="badge badge-warning"> Pending </span></h5>
@elseif($model->status == \App\Models\Order::STATUS_APPROVE)
    <h5><span class="badge badge-success"> Approve </span></h5>
@elseif($model->status == \App\Models\Order::STATUS_REJECT)
    <h5><span class="badge badge-danger"> Reject </span></h5>
@else
    --
@endif
