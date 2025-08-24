@extends('admin.layouts.master')

@section('title')
    Edit Admin
@endsection

@section('content')
    @include('admin.breadcrumbs', [
     'crumbs' => [
         'Edit Admin'
     ]
])
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('admin.admins.update',$admin) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-3 col-xl">
                                <label class="required" for="name">Name</label>
                                <input id="name" type="text" required name="name" class="form-control"
                                       placeholder="Enter Name"
                                       value="{{ old('name',$admin->name) }}">
                                @foreach($errors->get('name') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group mb-3 col-xl">
                                <label for="email" class="required">Email ID</label>
                                <input id="email" type="email" name="email"
                                       value="{{ old('email',$admin->email) }}"
                                       class="form-control" required autocomplete="off"
                                       placeholder="Enter Email ID">
                                @foreach($errors->get('email') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group mb-3 col-xl">
                                <label for="mobile" class="required">
                                    Mobile Number
                                </label>
                                <input id="mobile" type="text" name="mobile"
                                       value="{{ old('mobile',$admin->mobile) }}"
                                       required
                                       class="form-control" placeholder="Enter Mobile Number">
                                @foreach($errors->get('mobile') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group col-xl">
                                <label for="name" class="form-label required">Is Super Admin </label> <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                           onclick="checkPermissionTable(this.value)" name="is_super" id="yes"
                                           value="1" {{ old('is_super',$admin->is_super)?'checked':'' }} >
                                    <label class="form-check-label" for="yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                           onclick="checkPermissionTable(this.value)" name="is_super" id="no"
                                           value="0" {{ !old('is_super',$admin->is_super)?'checked':'' }}>
                                    <label class="form-check-label" for="no">No</label>
                                </div>
                                @foreach($errors->get('is_super') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                        </div>
                        <p><b style="color: red">Note :</b> Ensure that read permission is granted for users to access and view the module. Without read permission, the module will remain hidden, regardless of other permissions like create, delete, or update.
                        <div class="row">
                            <div class="col-12" id="permissionTable">
                                @foreach($errors->get('permissions') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                                <div class="table-responsive">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Permission</th>
                                                <th>All</th>
                                                <th>
                                                    <input id="main-checkbox-col-1" name="main-checkbox-col[]"
                                                           type="checkbox"
                                                           value="1"
                                                           class="form-check-input checkbox-item checkbox-for-column">
                                                    <label for="main-checkbox-col-1">Create</label>
                                                </th>
                                                <th>
                                                    <input id="main-checkbox-col-2" name="main-checkbox-col[]"
                                                           type="checkbox"
                                                           value="2"
                                                           class="form-check-input checkbox-item checkbox-for-column">
                                                    <label for="main-checkbox-col-2">Read</label>
                                                </th>
                                                <th>
                                                    <input id="main-checkbox-col-3" name="main-checkbox-col[]"
                                                           type="checkbox"
                                                           value="3"
                                                           class="form-check-input checkbox-item checkbox-for-column">
                                                    <label for="main-checkbox-col-3">Update</label>
                                                </th>
                                                <th>
                                                    <input id="main-checkbox-col-4" name="main-checkbox-col[]"
                                                           type="checkbox"
                                                           value="4"
                                                           class="form-check-input checkbox-item checkbox-for-column">
                                                    <label for="main-checkbox-col-4">Delete</label>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($permissions as $name => $permission)
                                                <tr>
                                                    <td>{{ $name }}</td>
                                                    <td>
                                                        <div class="checkbox checkbox-primary">
                                                            <input id="c{{ $name }}" type="checkbox"
                                                                   class="form-check-input checkbox-row checkbox-column-0"
                                                                {{ $admin->permissions->whereIn('id', $permission->pluck('id'))->count() === 4 ? 'checked="checked"' : '' }}
                                                            >
                                                            <label for="c{{ $name }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox checkbox-primary">
                                                            <input id="c{{ $permission[0]->id }}" type="checkbox"
                                                                   value="{{ $permission[0]->name }}"
                                                                   class="form-check-input checkbox-item checkbox-column-1"
                                                                   name="permissions[]"
                                                                {{ $admin->permissions->where('id', $permission[0]->id)->count() ? 'checked="checked"' : '' }}
                                                            >
                                                            <label for="c{{ $permission[0]->id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox checkbox-primary">
                                                            <input id="c{{ $permission[1]->id }}" type="checkbox"
                                                                   value="{{ $permission[1]->name }}"
                                                                   class="form-check-input checkbox-item checkbox-column-2"
                                                                   name="permissions[]"
                                                                {{ $admin->permissions->where('id', $permission[1]->id)->count() ? 'checked="checked"' : '' }}
                                                            >
                                                            <label for="c{{ $permission[1]->id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox checkbox-primary">
                                                            <input id="c{{ $permission[2]->id }}" type="checkbox"
                                                                   value="{{ $permission[2]->name }}"
                                                                   class="form-check-input checkbox-item checkbox-column-3"
                                                                   name="permissions[]"
                                                                {{ $admin->permissions->where('id', $permission[2]->id)->count() ? 'checked="checked"' : '' }}
                                                            >
                                                            <label for="c{{ $permission[2]->id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox checkbox-primary">
                                                            <input id="c{{ $permission[3]->id }}" type="checkbox"
                                                                   value="{{ $permission[3]->name }}"
                                                                   class="form-check-input checkbox-item checkbox-column-4"
                                                                   name="permissions[]"
                                                                {{ $admin->permissions->where('id', $permission[3]->id)->count() ? 'checked="checked"' : '' }}
                                                            >
                                                            <label for="c{{ $permission[3]->id }}"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                </div>
                            </div>

                        </div>
                            <div class="form-group mt-4 text-center">
                                <a href="{{ route('admin.admins.index') }}" class="btn btn-danger me-2">
                                    <i class="uil uil-multiply me-1"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="uil uil-message"></i>
                                    Update
                                </button>
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
            @if(old('is_super',$admin->is_super))
            checkPermissionTable({{ old('is_super',$admin->is_super) }});
            @endif
        });
        $('.checkbox-row').on('change', function () {
            toggleRow($(this));
        });

        $('.checkbox-for-column').click(function () {
            let isChecked = $(this).is(":checked");

            if ($('#main-checkbox-col-1').is(":checked") &&
                $('#main-checkbox-col-2').is(":checked") &&
                $('#main-checkbox-col-3').is(":checked") &&
                $('#main-checkbox-col-4').is(":checked")) {
                $('.checkbox-column-0').prop('checked', true);
            } else {
                $('.checkbox-column-0').prop('checked', false);
            }

            $('.checkbox-column-' + $(this).val()).prop('checked', isChecked);
        });

        $('.checkbox-item').on('change', function () {
            let checked = true;

            $(this).parents('tr').first()
                .children('td')
                .children('div')
                .children('.checkbox-item')
                .each(function (index, el) {
                    if (!$(el).prop('checked')) {
                        checked = false;
                    }
                });

            $(this).parents('tr').first()
                .children('td')
                .children('div')
                .children('.checkbox-row')
                .prop('checked', checked);
        });

        function toggleRow(el) {
            if (el.prop('checked')) {
                el.parents('td').siblings('td').children('div').children('input').prop('checked', true);
            } else {
                el.parents('td').siblings('td').children('div').children('input').prop('checked', false);
            }
        }

        function checkPermissionTable(val) {
            $('#permissionTable').show();
            if (val == 1) {
                $('#permissionTable').hide();
            }

        }

    </script>
@endpush
