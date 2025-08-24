<div id="addStock">
    @foreach($errors->get('products') as $error)
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Error!</strong> {{ $error }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endforeach
    <div class="table-responsive" v-if="selectedProducts.length">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>MRP</th>
                <th>DP</th>
                <th>SBV</th>
                <th>Quantity</th>
                <th>Total MRP</th>
                <th>Total DP</th>
                <th>Total SBV</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product, index) in selectedProducts">
                <input type="hidden" :name="'products[' + index + '][id]'" :value="product.id">
                <td>@{{ index + 1 }}</td>
                <td>@{{ product.name }}</td>
                <td>@{{ product.mrp }}</td>
                <td>@{{ product.dp }}</td>
                <td>@{{ product.sbv }}</td>
                <td>
                    <input type="number" :name="'products[' + index + '][quantity]'"
                           v-model="product.quantity" class="form-control" min="0">
                </td>
                <td>@{{ product.mrp * product.quantity }}</td>
                <td>@{{ product.dp * product.quantity }}</td>
                <td>@{{ product.sbv * product.quantity }}</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>MRP</th>
                <th>DP</th>
                <th>SBV</th>
                <th>Quantity</th>
                <th>@{{ totals.mrp }}</th>
                <th>@{{ totals.dp }}</th>
                <th>@{{ totals.sbv }}</th>
            </tr>
            </tfoot>
        </table>
    </div>
    <div id="addStockModal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="addStockModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addStockModalLabel">Add Stock</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group form-inline justify-content-end">
                        <label for="" class="mr-1">Search :</label>
                        <input type="text" class="form-control" placeholder="E.g. Ferrari" v-model="search">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>MRP</th>
                                <th>DP</th>
                                <th>SBV</th>
                                <th>Quantity</th>
                                <th>Total MRP</th>
                                <th>Total DP</th>
                                <th>Total SBV</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(product, index) in searchedProducts">
                                <td>@{{ index + 1 }}</td>
                                <td>@{{ product.name }}</td>
                                <td>@{{ product.mrp }}</td>
                                <td>@{{ product.dp }}</td>
                                <td>@{{ product.sbv }}</td>
                                <td>
                                    <input type="number" v-model="product.quantity"
                                           class="form-control"
                                           min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57"
                                    >
                                </td>
                                <td>@{{ product.mrp * product.quantity }}</td>
                                <td>@{{ product.dp * product.quantity }}</td>
                                <td>@{{ product.sbv * product.quantity }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <p class="alert alert-danger">Products having quantity more than zero are added automatically.</p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

@push('page-javascript')
    <script>
        new Vue({
            el: '#addStock',
            data: {
                products: {!!
                    $products->map(function(\App\Models\Product $product) {
                        $product->quantity = 0;

                        foreach (old('products', []) as $oldProduct) {
                            if ($oldProduct['id'] == $product->id) {
                                $product->quantity = (int)$oldProduct['quantity'];
                            }
                        }

                        return $product;
                    })->toJson()
                !!},
                search: ''
            },
            computed: {
                searchedProducts: function () {
                    if (this.search.length) {
                        let vm = this;

                        return this.products.filter(function (product) {
                            return product.name.indexOf(vm.search) !== -1;
                        });
                    } else {
                        return this.products;
                    }
                },
                selectedProducts: function () {
                    return this.products.filter(function (product) {
                        return product.quantity > 0;
                    });
                },
                totals: function () {
                    let totals = {
                        mrp: 0,
                        dp: 0,
                        sbv: 0,
                    };

                    if (this.selectedProducts.length) {
                        return this.selectedProducts.reduce(function (prev, product) {
                            return {
                                mrp: prev.mrp + parseFloat(product.mrp) * parseFloat(product.quantity),
                                dp: prev.dp + parseFloat(product.dp) * parseFloat(product.quantity),
                                sbv: prev.sbv + parseFloat(product.sbv) * parseFloat(product.quantity),
                            };
                        }, totals);
                    }

                    return totals;
                }
            }
        });
    </script>
@endpush
