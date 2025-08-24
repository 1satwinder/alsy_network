@extends('admin.layouts.master')

@section('title')
    Update Product
@endsection

@section('content')
    @include('admin.breadcrumbs', [
         'crumbs' => [
             'Update Product'
         ]
    ])
    <form action="{{ route('admin.products.update',$product) }}" method="post" enctype="multipart/form-data"
          class="filePondForm">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div id="app">
                            <div class="row">
                                <div class="form-group mb-3 col-lg-4 col-12">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="text" id="name" class="form-control"
                                               placeholder="e.g : Apple iMac"
                                               name="name"
                                               value="{{ old('name',$product->name) }}">
                                        <label for="name" class="required">Product Name</label>
                                    </div>
                                    @foreach($errors->get('name') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group mb-3 col-lg-4 col-12">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control" name="category_id"
                                                id="category_id" data-toggle="select2" required>
                                            <option value="">Select</option>
                                            @foreach($categories as $category)
                                                <optgroup label="{{ $category->name }}">
                                                    @foreach($category->children as $childCategory)
                                                        <option
                                                            value="{{ $childCategory->id }}"
                                                            {{ $childCategory->id == $product->category_id ? 'selected' : '' }}>
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
                                               value="{{ old('sku',$product->sku) }}">
                                        <label for="sku" class="required">Product Code </label>
                                    </div>
                                    @foreach($errors->get('sku') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group mb-3 col-xl-2">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">{{ env('APP_CURRENCY', ' र ') }}</span>
                                        <div class="form-floating form-floating-outline">
                                            <input required type="number" class="form-control" placeholder="MRP"
                                                   name="mrp"
                                                   id="mrp" step="0.01"
                                                   value="{{ old('mrp',$product->mrp) }}">
                                            <label for="mrp" class="required">MRP </label>
                                        </div>
                                    </div>
                                    @foreach($errors->get('dp') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group mb-3 col-xl-2">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">{{ env('APP_CURRENCY', ' र ') }}</span>
                                        <div class="form-floating form-floating-outline">
                                            <input required type="number" class="form-control" placeholder="DP"
                                                   name="dp"
                                                   id="dp" step="0.01"
                                                   value="{{ old('dp',$product->dp) }}">
                                            <label for="dp" class="required">DP </label>
                                        </div>
                                    </div>
                                    @foreach($errors->get('dp') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group mb-3 col-xl-2">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="number" class="form-control" placeholder="BV" id="bv"
                                               name="bv"
                                               value="{{ old('bv',$product->bv) }}">
                                        <label for="bv" class="required">BV</label>
                                    </div>
                                    @foreach($errors->get('bv') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group mb-3 col-xl-2">
                                    <div class="form-floating form-floating-outline">
                                        <select id="g_s_t_type_id" class="form-control" name="g_s_t_type_id"
                                                data-toggle="select2" required>
                                            <option value="">Select</option>
                                            @foreach($gstTypes as $gst)
                                                <option
                                                    value="{{ $gst->id }}"
                                                    {{ $gst->id == old('g_s_t_type_id', $product->g_s_t_type_id) ? 'selected' : '' }}>
                                                    {{ $gst->hsn_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="g_s_t_type_id" class="required">HSN Code</label>
                                    </div>
                                    @foreach($errors->get('g_s_t_type_id') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-lg-4 col-12">
                                <div class="form-floating form-floating-outline">
                                    <input required type="text" class="form-control"
                                           value="{{ $product->opening_stock }}"
                                           id="opening_stock" readonly>
                                    <label for="opening_stock">Opening Stock </label>
                                </div>
                            </div>
                            <div class="form-group mb-3 col-lg-4 col-12">
                                <div class="form-floating form-floating-outline">
                                    <input required type="text" class="form-control"
                                           value="{{ $product->company_stock }}"
                                           id="opening_stock" readonly>
                                    <label for="opening_stock">Current Stock </label>
                                </div>
                            </div>
                            <div class="form-group mb-3 col-lg-4 col-12">
                                <div class="form-floating form-floating-outline">
                                    <input id="opening_stock" type="text" name="qty" class="form-control"
                                           value="{{ old('qty') }}">
                                    <label for="opening_stock">Update Stock</label>
                                </div>
                                @foreach($errors->get('qty') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group col-12 col-lg-12 mb-3">
                                <label for="Description">Description</label>
                                <textarea class="form-control summernote-editor" rows="6" placeholder="Please enter description"
                                          name="description"
                                          id="Description">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-4 col-lg-4 col-xl mb-3">
                                <label class="required">Product Image</label>
                                <input required type="file" class="filePondInput" name="product_image"
                                       value="{{ optional($product)->getFirstMediaUrl(\App\Models\Product::MC_PRODUCT_IMAGE) }}"
                                       accept="image/*"/>
                                @foreach($errors->get('product_image') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            @for($i = 0; $i < 4; $i++)
                                <div class="form-group col-sm-12 col-md-4 col-lg-4 col-xl mb-3">
                                    <label>Product Image {{ $i + 1 }}</label>
                                    <input type="file" class="filePondInput" name="sub_images[]" accept="image/*"
                                           value="{{ isset($subImages[$i]) ? $subImages[$i]->getFullUrl() : '' }}">
                                    @foreach($errors->get("sub_images.$i") as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            @endfor
                        </div>
                        <div class="form-group col-12 col-lg-4 mb-0">
                            <div class="form-floating form-floating-outline">
                                <select class="form-control" name="status" id="comment" data-toggle="select2" required>
                                    <option
                                        value="{{ \App\Models\Product::STATUS_ACTIVE }}" {{ $product->status ==  \App\Models\Product::STATUS_ACTIVE ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option
                                        value="{{ \App\Models\Product::STATUS_IN_ACTIVE }}" {{ $product->status ==  \App\Models\Product::STATUS_IN_ACTIVE ? 'selected' : '' }}>
                                        In-Active
                                    </option>
                                </select>
                                <label for="comment" class="required">Status</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="uil uil-message me-1"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

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
@push('page-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
