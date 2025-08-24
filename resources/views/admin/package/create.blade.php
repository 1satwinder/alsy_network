@extends('admin.layouts.master')

@section('title')
    Create Package
@endsection

@section('content')
    @include('admin.breadcrumbs', [
        'crumbs' => [
            'Create Package'
        ]
    ])

    <form method="post" action="{{ route('admin.packages.store') }}"
          class="filePondForm"
          onsubmit="registerButton.disabled = true; return true;">
        @csrf
        <div class="row" >
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="header-title mb-0">Package Information</h5>
                    </div>

                    <div class="card-body" >
                        <div class="row">
                            <div class="form-group mb-3 col-lg-3">
                                <label for="example-input-large">
                                    Package Image <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="filePondInput" name="package_image"
                                       accept="image/*" required>
                                @foreach($errors->get('package_image') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div id="app">
                            <div class="row">

                                <div class="form-group col-md-3 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="packageName" required name="name" class="form-control"
                                               placeholder="Enter Package Name" value="{{ old('name') }}">
                                        <label class="required" for="packageName">Package Name</label>
                                        @foreach($errors->get('name') as $error)
                                            <div class="text-danger">{{ $error }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group col-md-3 mb-3">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">{{ env('APP_CURRENCY', ' र ') }}</span>
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" id="amount" class="form-control" :value="amount"
                                                   readonly disabled>
                                            <label for="amount" class="required">Amount</label>
                                        </div>
                                    </div>
                                    <span class="text-warning help-block">
                                        Total of all Product/Service price below.
                                    </span>
                                </div>
                                <div class="form-group col-lg-3 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input id="pv" type="number" required name="pv" class="form-control" min="0"
                                               placeholder="Enter PV" value="{{ old('pv') }}">
                                        <label for="pv">PV</label>
                                    </div>
                                    @foreach($errors->get('pv') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                            @foreach($errors->get('products') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                            <div class="row" v-for="(product, index) in products">
                                <div class="col-12 d-flex justify-content-between">
                                    <h5 class="text-primary">
                                        Product/Service #@{{ index + 1 }}
                                    </h5>
                                    <button type="button" @click="removeProduct(product)"
                                            class="btn btn-xs btn-danger mb-1"
                                            v-if="products.length > 1">
                                        <i class="uil uil-trash-alt"></i>
                                    </button>
                                </div>
                                <div class="form-group col-lg-3 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" :name="'products[' + index + '][name]'"
                                               class="form-control" id="productName"
                                               placeholder="Enter Product/Service Name" v-model="product.name" required>
                                        <label for="productName" class="required">Product/Service Name</label>
                                    </div>
                                    <span class="text-danger"
                                          v-for="error in  productErrors['products.' + index + '.name']">
                                        @{{ error }}
                                    </span>
                                </div>
                                <div class="form-group col-lg-3 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" required :name="'products[' + index + '][price]'"
                                               class="form-control" min="0" id="price"
                                               placeholder="Enter Price" v-model="product.price">
                                        <label class="required" for="price">Price</label>
                                    </div>
                                    <span class="text-danger"
                                          v-for="error in  productErrors['products.' + index + '.price']">
                                            @{{ error }}
                                        </span>
                                </div>
                                <div class="form-group col-lg-3 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" required :name="'products[' + index + '][hsn_code]'"
                                               class="form-control"
                                               placeholder="Enter HSN Code" v-model="product.hsn_code">
                                        <label class="required">HSN Code</label>
                                    </div>
                                    <span class="text-danger"
                                          v-for="error in  productErrors['products.' + index + '.hsn_code']">
                                            @{{ error }}
                                        </span>
                                </div>
                                <div class="form-group col-lg-3 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select :name="'products[' + index + '][gstSlab]'" class="form-control"
                                                v-model="product.gstSlab" required>
                                            <option value="">Select GST Slab</option>
                                            <option :value="slabIndex" v-for="(slab, slabIndex) in gstSlabs">
                                                @{{ slab }}
                                            </option>
                                        </select>
                                        <label class="required">GST Slab</label>
                                    </div>
                                    <span class="text-danger"
                                          v-for="error in  productErrors['products.' + index + '.gstSlab']">
                                        @{{ error }}
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary text-white" type="button" @click="addProduct">
                                        <i class='bx bx-plus me-1'></i> Add Product/Service
                                    </button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-12 text-center">
                                    <button type="submit" name="registerButton" class="btn btn-primary"><i
                                            class="uil uil-message me-1"></i> Submit
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
    <script>
        new Vue({
            el: '#app',
            data: {
                gstSlabs: {!! json_encode($gstSlabs) !!},
                products: {!! json_encode(old('products', [['gstSlab'=> '', 'price'=> 0]])) !!},
                productErrors: {!! json_encode($errors->get('products.*')) !!}
            },
            methods: {
                addProduct() {
                    this.products.push({
                        gstSlab: '',
                        price: 0,
                    });
                },
                removeProduct(product) {
                    this.products.splice(this.products.indexOf(product), 1);
                }
            },
            computed: {
                amount: function () {
                    let amount = 0;
                    this.products.forEach(function (product) {
                        amount += parseInt(product.price ? product.price : 0);
                    });

                    return amount;
                }
            }
        })
    </script>
@endpush
