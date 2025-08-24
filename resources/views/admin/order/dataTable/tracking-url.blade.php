@if($model->courier_tracking_url)
    <a href="{{ $model->courier_tracking_url }}"  class="btn btn-dark btn-sm font-weight-semibold" target="_blank">
        <i class="bx bx-link-external"></i>
    </a>
@else
    N/A
@endif
