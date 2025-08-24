@if($model->status == \App\Models\Product::STATUS_ACTIVE)
    <span class="btn btn-sm btn-success"> Active</span>
@endif

@if($model->status == \App\Models\Product::STATUS_IN_ACTIVE)
    <span class="btn btn-sm btn-danger"> In-Active</span>
@endif

