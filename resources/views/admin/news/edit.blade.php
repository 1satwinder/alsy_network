@extends('admin.layouts.master')
@section('title','Update News')

@section('content')
    @include('admin.breadcrumbs', [
       'crumbs' => [
           'Update News'
       ]
   ])
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('admin.news.update', $news)}}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="status" class="form-control" id="statusNew" data-toggle="select2" required="">
                                        <option value="1" {{ old('status',$news->status) == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="2" {{ old('status',$news->status) == 2 ? 'selected' : '' }}>
                                            In-Active
                                        </option>
                                    </select>
                                    <label for="statusNew" class="required">Status</label>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="title" class="form-control" id="title"
                                           value="{{ old('title',$news->title) }}" placeholder="Enter Title" required>
                                    <label for="title" class="required">Title</label>
                                </div>
                                @foreach($errors->get('title') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-md-12 text-center">
                                <button class="btn btn-primary" type="submit">
                                    <i class="uil uil-message me-1"></i>
                                   submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
