@extends('admin.layouts.master')
@section('title')
    Create Sub Image
@endsection

@section('content')
    @include('admin.breadcrumbs', [
         'crumbs' => [
             'Create Sub Image'
         ]
    ])
    <form method="POST" action="{{ route('admin.sub-photo-gallery.store', [$photoGallery]) }}" class="filePondForm">
        @csrf
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="example-input-large" class="required">Sub Image <small class="text-danger">(Width:1024px X Height 1024px)</small></label>
                            <input type="file" name="sub_image[]" class="filePondInput" multiple
                                   accept="image/*" required>
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
