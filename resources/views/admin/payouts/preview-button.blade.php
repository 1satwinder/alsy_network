<div class="btnAlign text-center justify-content-center">
    <form action="{{ route('admin.payouts.preview.show') }}" method="post">
        @csrf
        <a href="{{ route('admin.payouts.preview.show') }}"
           class="btn btn-danger waves-effect waves-light font-weight-bold">
            <i class="uil uil-coins me-2"></i> Preview Payout
        </a>
    </form>
</div>
