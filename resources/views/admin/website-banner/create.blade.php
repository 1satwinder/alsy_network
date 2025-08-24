@extends('admin.layouts.master')

@section('title')
    Banner Details
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Banners</li>
                    </ol>
                </div>
                <h4 class="page-title">Banners Details </h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <form method="post" action="{{ route('admin.website-banner.store') }}" class="filePondForm">
                @csrf
                <div class="card">
                <div class="card-body">
                    <h4 class="header-title required">Add Banner <span
                            class="text-danger">(Width:1920 x height:600 )</span></h4>
                    <div class="form-group mb-3">
                        <input type="file" class="filePondInput" name="image" accept="image/*" required>
                        @foreach($errors->get('image') as $error)
                            <span class="text-danger">{{ $error }}</span>
                        @endforeach
                    </div>
                    <div class="form-group mb-3">
                        <label>Banner Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter banner name"/>
                        @foreach($errors->get('name') as $error)
                            <span class="text-danger">{{ $error }}</span>
                        @endforeach
                    </div>
                    <div class="form-group mb-0">
                        <div class="d-flex justify-content-around">
                            <button type="submit" class="btn btn-success text-white">
                                <i class="uil uil-message mr-1"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
                </div>
            </form>
        </div>
        @foreach($banners as $index => $banner)
            <div class="col-lg-4">
                <form method="post" action="{{ route('admin.website-banner.update', $banner) }}"
                      class="filePondForm">
                    @csrf
                    <div class="card">
                    <div class="card-body">
                        <h5 class="header-title required">Banner: #{{ $index + 1 }}</h5>

                        <div class="form-group mb-3">
                            <input type="file" class="filePondInput" name="image" accept="image/*"
                                   data-url="{{ $banner->getFirstMediaUrl(\App\Models\Banner::MC_BANNER) }}"/>
                            @foreach($errors->get("image") as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <label>Banner Name</label>
                            <input type="text" class="form-control" name="name"
                                   placeholder="Enter banner name"
                                   value="{{ $banner->name }}"/>
                            @foreach($errors->get("name") as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <div class="form-group mb-3 d-flex justify-content-around">
                            <div class="radio radio-info form-check-inline ">
                                <input type="radio" id="active{{ $index }}"
                                       value="{{ \App\Models\Banner::STATUS_ACTIVE }}"
                                       name="status"
                                    {{ $banner->status == \App\Models\Banner::STATUS_ACTIVE ? 'checked="checked"' : '' }}
                                >
                                <label for="active{{ $index }}"> Active </label>
                            </div>
                            <div class="radio form-check-inline">
                                <input type="radio" id="inActive{{ $index }}"
                                       value="{{ \App\Models\Banner::STATUS_INACTIVE }}"
                                       name="status"
                                    {{ $banner->status == \App\Models\Banner::STATUS_INACTIVE ? 'checked="checked"' : '' }}
                                >
                                <label for="inActive{{ $index }}"> Inactive </label>
                            </div>
                            @foreach($errors->get("status") as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <div class="form-group mb-0">
                            <div class="d-flex justify-content-around">
                                <button type="submit" class="btn btn-primary">
                                    <i class="uil uil-image-edit"></i> Update
                                </button>
                                <button type="submit" class="btn btn-danger"
                                        form="deleteBanner{{ $banner->id }}">
                                    <i class="uil uil-trash-alt"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
                <form method="post" action="{{ route('admin.website-banner.destroy', $banner) }}"
                      enctype="multipart/form-data" id="deleteBanner{{ $banner->id }}">
                    @csrf
                    @method('delete')
                </form>
            </div>
        @endforeach
    </div>
@endsection

@include('admin.layouts.filepond')
