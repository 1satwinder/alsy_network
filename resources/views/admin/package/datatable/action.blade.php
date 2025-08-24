<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#view{{ $model->id }}">
    <i class="bx bx-show me-1"></i> View
</button>
<div id="view{{ $model->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Products/Services</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>HSN Code</th>
                            <th>GST Slab (%)</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($model->products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->hsn_code }}</td>
                                <td>{{ $product->present()->gstSlab() }} %</td>
                                <td>{{ $product->present()->price() }}</td>
                            </tr>
                        @endforeach
                        <tr class="font-weight-bold">
                            <td colspan="4" class="text-right">Total</td>
                            <td>₹ {{ $model->amount }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@if($model->isActive())
    <a href="{{ route('admin.packages.change-status', ['package' => $model, 'status' => \App\Models\Package::STATUS_INACTIVE]) }}"
       class="btn btn-danger btn-sm">
        <i class='uil uil-ban me-1'></i> In-Activate
    </a>
@elseif($model->isInActive())
    <a href="{{ route('admin.packages.change-status', ['package' => $model, 'status' => \App\Models\Package::STATUS_ACTIVE]) }}"
       class="btn btn-success btn-sm">
        <i class='bx bx-check me-1'></i> Activate
    </a>
@endif
