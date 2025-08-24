@extends('admin.layouts.master')

@section('title') {{ $parent ? 'Sub Category' : 'Category' }} @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-header bg-primary py-3 text-white">
                    <div class="card-widgets">
                        <div class="btn-group btn-group-md" role="group">
                            <a href="{{ route('admin.categories.create') }}"
                               class="btn btn-secondary waves-effect waves-light font-weight-bold">
                                <i class="uil uil-plus"></i> Create
                            </a>
                        </div>
                        <a data-toggle="collapse" href="#filters" role="button"
                           aria-expanded="{{ Agent::isMobile() ? 'true' : 'false'}}"
                           aria-controls="filters" class="{{ Agent::isMobile() ? 'collapsed' : ''}}">
                            <i class="uil uil-minus"></i>
                        </a>
                    </div>
                    <h5 class="card-title mb-0 text-white">
                        @if($parent)
                            @if(Agent::isMobile())
                                Sub Category <br><br><small class="text-break">({{ $parent->name }})</small>
                            @else
                                Sub Category -({{ $parent->name }})
                            @endif
                        @else
                            Category
                        @endif
                    </h5>
                </div>
                <div id="filters" class="collapse {{ Agent::isMobile() ? '' : 'show'}}">
                    <div class="card-body">
                        <form action="{{ route('admin.categories.index') }}" id="filterForm">
                            <div class="row">
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>From Date</label>
                                    <input type="date" name="created_at_from" class="form-control"
                                           placeholder="Date">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>To Date</label>
                                    <input type="date" name="created_at_to" class="form-control"
                                           placeholder="Date">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Category Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Category Name">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="{{\App\Models\Category::STATUS_ACTIVE}}"> Active</option>
                                        <option value="{{\App\Models\Category::STATUS_INACTIVE}}"> In-Active</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ route('admin.categories.index', $parent) }}"
                                       class="btn btn-danger waves-effect waves-light font-weight-bold">
                                        Reset
                                    </a>
                                    <button type="submit" name="filter" value="filter" onclick="shouldExport = false;"
                                            class="btn btn-primary waves-effect waves-light font-weight-bold">
                                        Apply Filter
                                    </button>
                                    {{--                                    <button type="submit" name="export" value="csv" onclick="shouldExport = true;"--}}
                                    {{--                                            class="btn btn-secondary waves-effect waves-light font-weight-bold float-right">--}}
                                    {{--                                        Export--}}
                                    {{--                                    </button>--}}
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
                   @if($parent)
                       <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Back</a>
                   @endif
                   <form action="{{ route('admin.categories.status-update') }}" method="post">
                       @csrf
                       <div class="row">
                           <div class="form-group col-md-3 col-8">
                               <label>Status</label>
                               <select name="changeStatus" class="form-control" data-toggle="select2" required>
                                   <option value="">Select Status</option>
                                   <option value="{{\App\Models\Category::STATUS_ACTIVE}}"> Active</option>
                                   <option value="{{\App\Models\Category::STATUS_INACTIVE}}"> In-Active</option>
                               </select>

                           </div>
                           <div class="form-group col-md-3 col-4">
                               <label for="">&nbsp;</label><br>
                               <button type="submit" class="btn btn-primary waves-effect waves-light" disabled
                                       data-toggle="modal" data-target="#large-modal" id="disableButton">
                                   Submit
                               </button>
                           </div>
                       </div>
                       <div class="table-responsive">
                           <table class="table table-hover table-bordered table-striped" id="categoryTable">
                               <thead>
                               <tr>
                                   <th>#</th>
                                   <th>
                                       <div class="checkbox checkbox-primary checkbox-single">
                                           <input type="checkbox" class="checkBox" id="allSelect" value=""
                                                  onchange="checkAll(this)"
                                                  name="category[]">
                                           <label for="allSelect"></label>
                                       </div>
                                   </th>
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

        $(document).ready(function () {
            $('#disableButton').css('cursor', 'not-allowed');
        });

        $('body').on('change', '.checkBox', function () {
            if ($('.checkBox:checked').length > 0) {
                $('#disableButton').prop('disabled', false);
                $('#disableButton').css('cursor', 'pointer');
            } else {
                $('#disableButton').css('cursor', 'not-allowed');
                $('#disableButton').prop('disabled', true);
            }
        });

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

        var dataTable = $('#categoryTable').DataTable({
            ajax: {
                url: '{{ route('admin.categories.index', ['parent' => optional($parent)->id]) }}',
            },
            "columns": [
                {data: 'DT_RowIndex', width: '5%'},
                {name: "checkbox", data: "checkbox"},
                {name: "created_at", data: "created_at"},
                {name: "name", data: "name"},
                {name: "status", data: "status"},
                {name: "action", data: "action"},
            ]
        });
    </script>
@endpush
