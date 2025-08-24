<form action="{{ route('admin.category-sliders.destroy', $model) }}" method="post" onsubmit="registerButton.disabled = true; return true;">
    @csrf
    <button type="submit" name="registerButton" class="btn btn-outline-danger btn-sm">
        <i class="bx bx-trash me-2"></i> Delete
    </button>
</form>
