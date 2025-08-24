@if ($model->is_data)
    <a href="{{ route('admin.pin-requests.approve', $model->id) }}" class="btn btn-success btn-sm mb-1">
        <i class='bx bx-check-circle me-2'></i> Approve
    </a>
    <a href="{{ route('admin.pin-requests.reject', $model->id) }}" class="btn btn-danger btn-sm mb-1">
        <i class='bx bx-stop-circle ms-2'></i> Reject
    </a>
@else
    N/A
@endif
