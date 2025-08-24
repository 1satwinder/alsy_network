@extends('admin.layouts.master')

@section('title') Create GST Types @endsection

@section('content')
    @include('admin.breadcrumbs', [
       'crumbs' => [
           'Create GST Types'
       ]
   ])
    <form method="post" action="{{ route('admin.gst-types.store') }}">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="hsn_code" class="form-control" id="hsn_code"
                                           placeholder="Enter HSN Code" value="{{ old('hsn_code') }}" required>
                                    <label for="hsn_code" class="required">HSN Code</label>
                                </div>
                                @foreach($errors->get('hsn_code') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" name="sgst" id="sgst" class="form-control" min="0" step="0.01"
                                           placeholder="Enter SGST" value="{{ old('sgst') }}" required>
                                    <label for="sgst" class="required">SGST</label>
                                </div>
                                @foreach($errors->get('sgst') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" name="cgst" id="cgst" class="form-control" min="0" step="0.01"
                                    placeholder="Enter CGST" value="{{ old('cgst') }}" required>
                                    <label for="cgst" class="required">CGST</label>
                                </div>
                                @foreach($errors->get('sgst') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary waves-effect">
                                    <i class="uil uil-message me-1"></i> Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
