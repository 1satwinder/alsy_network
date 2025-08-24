@extends('admin.layouts.master')
@section('title')
    Edit Sub Image Photo Gallery
@endsection

@section('content')
    @include('admin.breadcrumbs', [
         'crumbs' => [
             ' Edit Sub Image Photo Gallery'
         ]
    ])
    <form method="POST" action="{{ route('admin.sub-photo-gallery.update',[$subPhotoGallery]) }}"
          class="filePondForm">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <select name="status" class="form-control" id="statusS" data-toggle="select2" required>
                                    <option value=""> Select</option>
                                    <option
                                        value="1" {{ old('status', $subPhotoGallery->status) == \App\Models\SubPhotoGallery::STATUS_ACTIVE ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option
                                        value="2" {{ old('status', $subPhotoGallery->status) == \App\Models\SubPhotoGallery::STATUS_INACTIVE ? 'selected' : '' }}>
                                        In-Active
                                    </option>
                                </select>
                                <label for="statusS" class="required">Status</label>
                            </div>
                            @foreach($errors->get('status') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <label for="example-input-large" class="required">Sub Image <small class="text-danger">(Width:1024px X Height 1024px)</small></label>
                            <input type="file" class="filePondInput" name="sub_image" accept="image/*"
                                   data-url="{{ $subPhotoGallery->getFirstMediaUrl(\App\Models\SubPhotoGallery::SUB_IMAGE) }}"
                                   required>
                            @foreach($errors->get('sub_image') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="uil uil-message me-1"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@include('admin.layouts.filepond')
