@if($model->isPending())
        <form action="{{ route('admin.withdrawal-requests.update', $model) }}"
              method="post" class="d-inline">
            @csrf
            <button name="status"
                    value="{{ \App\Models\WithdrawalRequest::STATUS_APPROVED }}"
                    class="btn btn-success btn-sm text-white">
                Approve
            </button>
        </form>
        <form action="{{ route('admin.withdrawal-requests.update', $model) }}"
              method="post" class="d-inline">
            @csrf
            <button name="status"
                    value="{{ \App\Models\WithdrawalRequest::STATUS_REJECTED }}"
                    class="btn btn-danger btn-sm text-white">
                Reject
            </button>
        </form>
@else
    --
@endif
