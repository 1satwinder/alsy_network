@extends('admin.layouts.master')
@section('title','Create News')

@section('content')
    @include('admin.breadcrumbs', [
       'crumbs' => [
           'Create News'
       ]
   ])
    <form action="{{ route('admin.news.store') }}" method="post" role="form" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="title" id="title" class="form-control"
                                       value="{{ old('title') }}"
                                       placeholder="Enter Title" required="">
                                <label for="title" class="required">Title</label>
                            </div>
                            @foreach($errors->get('title') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <button class="btn btn-primary" type="submit">
                                <i class="uil uil-message me-1"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
