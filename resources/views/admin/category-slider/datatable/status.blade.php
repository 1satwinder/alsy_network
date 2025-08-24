@if($model->status == \App\Models\CategorySlider::ACTIVE)
    <span class="btn btn-success btn-sm waves-effect waves-light font-weight-bold"> Active </span>
@endif
@if($model->status == \App\Models\CategorySlider::INACTIVE)
    <span class="btn btn-danger btn-sm waves-effect waves-light font-weight-bold"> In-Active </span>
@endif
