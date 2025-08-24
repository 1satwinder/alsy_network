@if($model->getFirstMediaUrl(\App\Models\FundRequest::MC_RECEIPT))
    <a href="{{ $model->getFirstMediaUrl(\App\Models\FundRequest::MC_RECEIPT) }}" class='image-popup' data-toggle='tooltip'
       data-original-title='Click here to zoom image'>
        <img alt="RECEIPT" class='avatar-md' src="{{ $model->getFirstMediaUrl(\App\Models\FundRequest::MC_RECEIPT) }}">
    </a>
@else
    N/A
@endif
