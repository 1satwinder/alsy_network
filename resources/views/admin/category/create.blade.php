@extends('admin.layouts.master')

@section('title')
    Create Category
@endsection

@section('content')
    @include('admin.breadcrumbs', [
    'crumbs' => [
        'Create Category'
        ]
    ])
    <form method="post" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <div class="form-group mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select name="parent_id" id="parent_id" class="form-control"
                                                data-toggle="select2">
                                            <option value="">Select Main Category</option>
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="parent_id" class="">Parent Name</label>
                                    </div>
                                    @foreach($errors->get('parent_id') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="name" id="name" class="form-control"
                                               placeholder="Enter Category Name" value="{{ old('name') }}" required>
                                        <label class="required" for="name">Category Name</label>
                                    </div>
                                    @foreach($errors->get('name') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
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
