<a href="{{ optional($model)->getFirstMediaUrl(\App\Models\Package::MC_PACKAGE_IMAGE) ?: '/images/no_image.png' }}" class="image-popup img-thumbnail avatar-sm"
   title="{{ $model->name }}">
    <img src="{{ optional($model)->getFirstMediaUrl(\App\Models\Package::MC_PACKAGE_IMAGE) ?: '/images/no_image.png' }}" class="img-fluid" alt="">
</a>
