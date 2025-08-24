@extends('admin.layouts.master')
@section('title','Create Video')

@section('content')
    @include('admin.breadcrumbs', [
        'crumbs' => [
            'Create Video'
        ]
   ])
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.video.store')}}" method="post" role="form" >
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label>Title</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                           value="{{ old('title') }}" required>
                                    @foreach($errors->get('title') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label>Link</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="link" class="form-control" placeholder="Enter Link"
                                           value="{{ old('link') }}" required>
                                    @foreach($errors->get('link') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label>Description</label>
                                    <span class="text-danger">*</span>
                                    <textarea type="text" name="description" class="form-control" placeholder="Enter Description"
                                              required>{{ old('description') }}</textarea>
                                    @foreach($errors->get('description') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="uil uil-message me-1"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.layouts.filepond')
