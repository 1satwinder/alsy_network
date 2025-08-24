@extends('admin.layouts.master')

@section('title')
    Category Slider
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">Category Sliders</h5>
                </div>
                <div id="filters" class="collapse {{ Agent::isMobile() ? '' : 'show'}}">
                    <div class="card-body">
                        <form action="{{ route('admin.category-sliders.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-xl-3 col-lg-3 col-md-3 col-6">
                                    <div class="form-floating form-floating-outline">
                                        <select name="category" id="category" class="form-control"
                                                onchange="subCategory(this.value)"
                                                data-toggle="select2" required>
                                            <option value="">Select Main Category</option>
                                            @foreach($category as $categories)
                                                <option value="{{ $categories->id }}">{{$categories->name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="category" class="required">ADD CATEGORY SLIDERS </label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-floating form-floating-outline">
                                        <select name="sub_id" id="sub_id" class="form-control"
                                                data-toggle="select2" required>
                                            <option value="">Sub Category</option>
                                        </select>
                                        <label for="sub_id">&nbsp;Sub Category</label><br>
                                    </div>
                                    @foreach($errors->get('sub_id') as $error)
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
                                        <i class="uil uil- me-1 font-weight-bold mr-1"></i> Submit
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
                    <form action="{{ route('admin.category-sliders.update-status') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-2">
                                <select name="status" class="form-control" data-toggle="select2" >
                                    <option value="1">Active</option>
                                    <option value="2">In-Active</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <button type="submit" name="updateStatus" value="updateStatus" class="btn btn-lg btn-primary">
                                    Change Status
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="categorySliderTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Action</th>
                                    <th>Date</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('page-javascript')
    <script>
        function subCategory(parent_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: route('admin.categories.sub-category'),
                data: {parent_id: parent_id, _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                success: function (data) {
                    // alert(data);
                    $('#sub_id').html('<option value="">Select Sub Category</option>');

                    $.each(data, function (key, value) {
                        var old_Seelcted = (value.id == '{{ old('sub_id') }}' ? 'selected' : '');
                        if (old_Seelcted == 'selected') {
                            $('#sub_id').append(' <option value=' + value.id + '  ' + old_Seelcted + '>' + value.name + '</option>');
                        } else {
                            $('#sub_id').append(' <option value=' + value.id + '>' + value.name + '</option>');

                        }
                    });
                },
                error: function () {
                    $('#sub_id').html('<option value="">Select Sub Category</option>');
                }
            });
        }

        var dataTable = $('#categorySliderTable').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.category-sliders.show") }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'create-date', name: 'create-date', searchable: false, orderable: false},
                {data: 'created_at', name: 'created_at', searchable: false, orderable: false},
                {data: 'category.name', name: 'category.name'},
                {data: 'status', name: 'status', searchable: false, orderable: false},
                {data: 'action', name: 'action', searchable: false, orderable: false},
            ]
        });
    </script>
@endpush
