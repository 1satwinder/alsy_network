<a href="{{ $model->getFirstMediaUrl(\App\Models\PhotoGallery::MAIN_IMAGE) }}" class='image-popup' data-toggle='tooltip'
   data-original-title='Click here to zoom image'>
    <img alt="QR Image" class='avatar-sm' src="{{ $model->getFirstMediaUrl(\App\Models\PhotoGallery::MAIN_IMAGE) }}">
</a>
