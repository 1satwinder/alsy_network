@extends('admin.layouts.master')

@section('title')
    Edit {{ $category->parent ? 'Sub Category' : 'Category' }}
@endsection

@section('content')
    @include('admin.breadcrumbs', [
    'crumbs' => [
        ' Edit '.$category->parent ? 'Sub Category' : 'Category'
        ]
    ])
    <form method="post" action="{{route('admin.categories.update', $category)}}">
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
                                            <option value="">Main Category</option>
                                            @foreach($parentCategories as $parentCategory)
                                                <option value="{{ $parentCategory->id }}"
                                                    {{ $parentCategory->id == $category->parent_id ? 'selected' : '' }}
                                                >
                                                    {{ $parentCategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="parent_id">Parent Name</label>
                                    </div>
                                    @foreach($errors->get('parent_id') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="name" class="form-control" id="name"
                                               placeholder="Enter Category Name"
                                               value="{{ old('name',$category->name) }}"
                                               required>
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
                                    <i class="uil uil-message me-1"></i>Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
