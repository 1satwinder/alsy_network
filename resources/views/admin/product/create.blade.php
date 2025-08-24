@extends('admin.layouts.master')

@section('title')
    Create Product
@endsection

@section('content')
    @include('admin.breadcrumbs', [
         'crumbs' => [
             'Create Product'
         ]
    ])
    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data" class="filePondForm">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="app">
                            <div class="row">
                                <div class="form-group mb-3 col-lg-4 col-12">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="text" id="name" class="form-control"
                                               placeholder="e.g : Apple iMac"
                                               name="name"
                                               value="{{ old('name') }}">
                                        <label for="name" class="required">Product Name</label>
                                    </div>
                                    @foreach($errors->get('name') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group mb-3 col-lg-4 col-12">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control" name="category_id" id="category_id"
                                                data-toggle="select2"
                                                required="">
                                            <option value="">Select</option>
                                            @foreach($categories as $category)
                                                <optgroup label="{{ $category->name }}">
                                                    @foreach($category->children as $childCategory)
                                                        <option
                                                            value="{{ $childCategory->id }}"
                                                            {{ $childCategory->id == old('category_id') ? 'selected' : '' }}
                                                        >
                                                            {{ $childCategory->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <label for="category_id" class="required">Categories</label>
                                    </div>
                                    @foreach($errors->get('category_id') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group mb-3 col-lg-4 col-12">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="text" id="sku" class="form-control"
                                               placeholder="e.g : SKU1564"
                                               name="sku"
                                               value="{{ old('sku') }}">
                                        <label for="sku" class="required">Product Code</label>
                                    </div>
                                    @foreach($errors->get('sku') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group mb-3 col-xl-2 ">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">{{ env('APP_CURRENCY', ' र ') }}</span>
                                        <div class="form-floating form-floating-outline">
                                            <input required type="number" class="form-control" placeholder="MRP"
                                                   id="mrp"
                                                   name="mrp" step="0.01"
                                                   value="{{old('mrp')}}">
                                            <label for="mrp" class="required">MRP</label>
                                        </div>
                                    </div>
                                    @foreach($errors->get('mrp') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group mb-3 col-xl-2 ">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">{{ env('APP_CURRENCY', ' र ') }}</span>
                                        <div class="form-floating form-floating-outline">
                                            <input required type="number" class="form-control" placeholder="DP"
                                                   name="dp"
                                                   id="dp" step="0.01"
                                                   value="{{old('dp')}}">
                                            <label for="dp" class="required">DP</label>
                                        </div>
                                    </div>
                                    @foreach($errors->get('dp') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group mb-3 col-xl-2 ">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="number" class="form-control" placeholder="BV" id="bv"
                                               name="bv"
                                               value="{{old('bv')}}">
                                        <label for="bv" class="required">BV</label>
                                    </div>
                                    @foreach($errors->get('bv') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group mb-3 col-xl-2 ">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control" required name="g_s_t_type_id" id="g_s_t_type_id"
                                                data-toggle="select2">
                                            <option value="">Select</option>
                                            @foreach($gstTypes as $gst)
                                                <option
                                                    value="{{ $gst->id }}"
                                                    {{ $gst->id == old('g_s_t_type_id') ? 'selected' : '' }}
                                                >
                                                    {{ $gst->hsn_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="g_s_t_type_id" class="required">HSN Code </label>
                                    </div>
                                    @foreach($errors->get('g_s_t_type_id') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group mb-3 col-xl-2">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="number" id="opening_stock" class="form-control"
                                               placeholder="e.g :15"
                                               name="opening_stock" value="{{ old('opening_stock') }}">
                                        <label for="opening_stock" class="required">Opening Stock</label>
                                    </div>
                                    @foreach($errors->get('opening_stock') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="description">Description</label>
                                    <textarea class="form-control summernote-editor" rows="6" placeholder="Please enter description"
                                              name="description" id="description">{{ old('description') }}</textarea>
                                    @foreach($errors->get('description') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-4 col-lg-4 col-xl mb-3">
                                <label class="required">Product Image</label>
                                <input required type="file" class="filePondInput" name="image" accept="image/*">
                                @foreach($errors->get('image') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>

                            @for($i = 0; $i < 4; $i++)
                                <div class="form-group col-sm-12 col-md-4 col-lg-4 col-xl mb-3">
                                    <label>Product Image {{ $i + 1 }}</label>
                                    <input type="file" class="filePondInput" name="sub_images[]" accept="image/*">
                                    @foreach($errors->get("sub_images.$i") as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="uil uil-message me-1"></i> Submit
                                    </button>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('page-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('page-javascript')
    <script src="{{ asset('js/vapor.min.js') }}"></script>
    <script src="{{ asset('js/filepond.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            $(".summernote-editor").summernote({
                tabsize: 2,
                height: 250,
                focus: !1,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    // ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['height', ['height']],
                    ['view', ['codeview']]
                ]
            });
        });
    </script>
@endpush
