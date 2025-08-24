@if($model->status == \App\Models\PhotoGallery::STATUS_ACTIVE)<div class="btn btn-success btn-sm waves-effect waves-light">Active</div>@endif
@if($model->status == \App\Models\PhotoGallery::STATUS_INACTIVE)<div class="btn btn-danger btn-sm waves-effect waves-light">In-Active</div>@endif
