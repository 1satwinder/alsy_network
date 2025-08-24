@extends('admin.layouts.master')
@section('title')
    Create Photo Gallery
@endsection

@section('content')
    @include('admin.breadcrumbs', [
         'crumbs' => [
             'Create Photo Gallery'
         ]
    ])
    <form method="POST" action="{{ route('admin.photo-gallery.store') }}" class="filePondForm">
        @csrf
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="title" id="title" class="form-control"
                                       placeholder="Enter Title" value="{{ old('title') }}" required>
                                <label for="title" class="required">Title</label>
                            </div>
                            @foreach($errors->get('title') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <label for="example-input-large" class="required">Main Image <small class="text-danger">(Width:400px X Height 250px)</small></label>
                            <input type="file" name="main_image" class=" filePondInput" accept="image/*" required>
                            @foreach($errors->get('main_image') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                        <div class="col-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="uil uil-message me-1"></i> Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@include('admin.layouts.filepond')
