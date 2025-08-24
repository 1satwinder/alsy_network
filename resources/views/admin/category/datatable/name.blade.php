@if($model->children_count > 0)
    <a href="{{ route('admin.categories.index', ['parent' => $model->id]) }}">
        {{ $model->name }} <span class="badge bg-dark rounded-pill ms-auto">{{ $model->children_count }}</span>
    </a>
@else
    {{ $model->name }}
@endif

