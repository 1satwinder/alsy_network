@if($model->payment_status == \App\Models\Order::PAYMENT_CAPTURE)
    <a href="{{route('member.orders.invoice',$model)}}" class="btn btn-primary text-white" download="">
        Invoice
    </a>
@endif
