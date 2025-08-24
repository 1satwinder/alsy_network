@extends('admin.layouts.master')

@section('title') Edit Video @endsection

@section('content')

    @include('admin.breadcrumbs', [
      'crumbs' => [
          'Edit Video'
      ]
 ])
    <form method="post" action="{{route('admin.video.update', $video)}}" >
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label>Title</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                           value="{{ old('title',optional($video)->title) }}" required>
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
                                           value="{{ old('link',optional($video)->link) }}" required>
                                    @foreach($errors->get('link') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label>Description</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="description" class="form-control" placeholder="Enter Description"
                                           value="{{ old('description',optional($video)->description) }}" required>
                                    @foreach($errors->get('description') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-sm-center">
                                <button type="submit" class="btn btn-danger text-white"><i
                                        class="mdi mdi-send mr-1"></i> Submit
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
