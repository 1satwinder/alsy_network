@if($model->payment_status == \App\Models\Order::PAYMENT_CAPTURE)
    <a href="{{ route('admin.orders.order.invoice',$model) }}" download=""
       class="btn btn-dark btn-sm font-weight-bold">
        <i class="uil uil-print"></i>
    </a>
@endif
