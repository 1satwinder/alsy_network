@extends('admin.layouts.master')
@section('title')
    Edit Photo Gallery
@endsection

@section('content')
    @include('admin.breadcrumbs', [
         'crumbs' => [
             'Edit Photo Gallery'
         ]
    ])
    <form method="POST" action="{{route('admin.photo-gallery.update',$photoGallery)}}" class="filePondForm">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="title" class="form-control" id=title"
                                       placeholder="Enter Title" value="{{ old('title',$photoGallery->title) }}"
                                       required>
                                <label for="title" class="required">Title</label>
                            </div>
                            @foreach($errors->get('title') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <label for="main_image" class="required">Main Image <small class="text-danger">(Width:400px X Height 250px)</small></label>
                            <input type="file" name="main_image" class="filePondInput"
                                   data-url="{{ $main_image }}"
                                   accept="image/*" required>
                            @foreach($errors->get('main_image') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <div class="form-floating form-floating-outline">
                                <select name="status" class="form-control" id="statusP" data-toggle="select2" required>
                                    <option value=""> Select</option>
                                    <option
                                        value="1" {{ old('status', $photoGallery->status) == \App\Models\PhotoGallery::STATUS_ACTIVE ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option
                                        value="2" {{ old('status', $photoGallery->status) == \App\Models\PhotoGallery::STATUS_INACTIVE ? 'selected' : '' }}>
                                        In-Active
                                    </option>
                                </select>
                                <label for="statusP" class="required">Status</label>
                            </div>
                            @foreach($errors->get('status') as $error)
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
