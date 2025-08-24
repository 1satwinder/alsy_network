<a href="{{ route('admin.orders.details', $model) }}" target="_blank"
   class="btn btn-success btn-sm font-weight-semibold">
    <i class="bx bx-show"></i> Detail
</a>

@if($model->transaction_id == null && $model->pay_by==\App\Models\Order::PAY_BY_ONLINE)
    <a href="{{ route('admin.orders.transaction.id.edit', $model) }}" target="_blank" class="btn btn-primary btn-sm font-weight-semibold">
        <i class="uil uil-edit-alt"></i> Update PG ID
    </a>
@endif
