@if($model->status == \App\Models\PhotoGallery::STATUS_ACTIVE)
    <span class="btn btn-sm btn-success"> Active</span>
@endif
@if($model->status == \App\Models\PhotoGallery::STATUS_INACTIVE)
    <span class="btn btn-sm btn-danger"> In-Active</span>
@endif
