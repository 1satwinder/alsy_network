@if($model->getFirstMediaUrl(\App\Models\Bank::MC_QR_CODE))
    <a href="{{ $model->getFirstMediaUrl(\App\Models\Bank::MC_QR_CODE) }}" class='image-popup' data-toggle='tooltip'
       data-original-title='Click here to zoom image'>
        <img alt="QR Image" class='avatar-sm' src="{{ $model->getFirstMediaUrl(\App\Models\Bank::MC_QR_CODE) }}">
    </a>
@else
    N/A
@endif
