<div class="btn-group">
    <button type="button" class="btn btn-sm btn-default dropdown-toggle waves-effect"
            data-toggle="dropdown" aria-expanded="false">
        <i class='bx bx-dots-vertical-rounded' ></i>
    </button>
    <div class="dropdown-menu droplist">
        <a class="dropdown-item" href="{{route('member.orders.order-product',$model)}}" target="_blank">
            <i class="uil uil-eye"></i> Order Details
        </a>
        @if($model->payment_status == \App\Models\Order::PAYMENT_CAPTURE)
            <a class="dropdown-item"
               href="{{ route('member.orders.invoice',$model) }}" download="">
                <i class="uil uil-receipt-alt"></i> Invoice
            </a>
        @endif
    </div>
</div>
