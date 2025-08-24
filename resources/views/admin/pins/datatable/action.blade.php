@if(!$model->isUsed())
    @if($model->isBlocked())
        <form action="{{ route('admin.pins.block.destroy', $model) }}" method="post">
            @csrf
            @method('delete')
            <button class="btn btn-success btn-sm">
                <i class="fa fa-check"></i> Un-Block
            </button>
        </form>
    @else
        <form action="{{ route('admin.pins.block.store', $model) }}" method="post">
            @csrf
            <button class="btn btn-danger btn-sm">
                <i class="fa fa-ban"></i> Block
            </button>
        </form>
    @endif
@endif
