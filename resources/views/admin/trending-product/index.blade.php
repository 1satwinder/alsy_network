@extends('admin.layouts.master')

@section('title')Trending Products @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">Trending Products</h5>
                </div>
                <div id="filters" class="collapse {{ Agent::isMobile() ? '' : 'show'}}">
                    <div class="card-body">
                        <form action="{{ route('admin.trending-products.store') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group mb-3 col-lg-4 col-12">
                                    <label for="Product_id">Product List</label>
                                    <select name="product_id[]" id="Product_id" class="form-control products" data-toggle="select2"
                                            data-placeholder="Select Products List" multiple>
                                        <option value="" disabled>Select Product</option>
                                        @foreach( $products as $product )
                                            <option
                                                value="{{ $product->id }}" {{ old('product_id') == $product->name ? 'selected' : '' }}
                                            >
                                            {{ $product->name }}
                                        @endforeach
                                    </select>
                                    @foreach($errors->get('product_id') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="" class="btn btn-outline-danger waves-effect waves-light font-weight-bold">
                                        Reset
                                    </a>
                                    <button type="submit" name="submit" value="Submit" onclick="shouldExport = false;"
                                            class="btn btn-outline-primary waves-effect waves-light font-weight-bold">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex">
                            <form action="{{ route('admin.trending-products.delete') }}" method="post" id="multiDelete">
                                @csrf
                                <button type="submit" class="btn btn-danger my-2 mx-2">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped vertical-middle" id="tblLocations">
                            <thead>
                            <tr class="headtr">
                                <th>
                                    <div class="form-check form-check-primary mb-0">
                                        <input class="form-check-input" type="checkbox" id="allSelect"
                                               value="" name="category[]" onchange="checkAll(this)">
                                        <label class="form-check-label" for="allSelect"></label>
                                    </div>
                                </th>
                                <th>Date</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($trendingProducts as $index =>$trendingProduct)
                                <tr>
                                    <td>
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="checkbox"
                                                   value="{{ $trendingProduct->id }}" name="trendingProductIds[]"  form="multiDelete"/>
                                            <label class="form-check-label" for="allSelect"></label>
                                        </div>
                                    </td>
                                    <td>{{ $trendingProduct->created_at }}</td>
                                    <td>{{ $trendingProduct->product_id }}</td>
                                    <td>{{ $trendingProduct->product->name }}</td>
                                    <td>
                                        <form action="{{ route('admin.trending-products.delete') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="trendingProductIds[0]"
                                                   value="{{ $trendingProduct->id }}"/>
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="uil uil-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page-javascript')
    <script type="text/javascript">
        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }

        $(".products").select2({
            placeholder: "Select multiple products"
        });
    </script>
@endpush
