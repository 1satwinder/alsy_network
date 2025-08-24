@if ($model->isPending())
    <a type="button" href="{{ route('admin.pin-requests.approve', $model->id) }}"
       class="btn btn-success btn-sm mb-1">
        <i class='bx bx-check me-1'></i> Approve
    </a>
    <a type="button" href="{{ route('admin.pin-requests.reject', $model->id)}}"
       class="btn btn-danger btn-sm mb-1">
        <i class='bx bx-block me-1'></i> Reject
    </a>
@else
    N/A
@endif
