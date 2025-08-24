@extends('admin.layouts.master')

@section('title')
    Legal Documents
@endsection

@section('content')
    @include('admin.breadcrumbs', [
       'crumbs' => [
           'Legal Documents'
       ]
   ])
    <div class="row">
        <div class="col-lg-4">
            <form method="post" action="{{ route('admin.legal.store') }}" class="filePondForm">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="header-title required">Image</h5>
                        <div class="form-group mb-3">
                            <input type="file" class="filePondInput" name="image" accept="image/*" required>
                            @foreach($errors->get('image') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="name" placeholder="Enter Document Name"
                                       id="document">
                                <label class="document">Document Name</label>
                            </div>
                            @foreach($errors->get('name') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <div class="form-group mb-0">
                            <div class="d-flex justify-content-around">
                                <button type="submit" class="btn btn-primary">
                                    <i class="uil uil-message me-1"></i> Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @foreach($legalDocuments as $index => $legalDocument)
            <div class="col-lg-4">
                <form method="post" action="{{ route('admin.legal.update', $legalDocument) }}"
                      class="filePondForm">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="header-title required">Image: #{{ $index + 1 }}</h5>

                            <div class="form-group mb-3">
                                <input type="file" class="filePondInput" name="image" accept="image/*"
                                       data-url="{{ $legalDocument->getFirstMediaUrl(\App\Models\LegalDocument::MC_LEGAL_DOCUMENTS) }}"/>
                                @foreach($errors->get("image") as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group mb-3">
                                <label>Document Name</label>
                                <input type="text" class="form-control" name="name"
                                       placeholder="Enter Document name"
                                       value="{{ $legalDocument->name }}"/>
                                @foreach($errors->get("name") as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group mb-3 d-flex justify-content-around">
                                <div class="radio radio-info form-check-inline ">
                                    <input type="radio" id="active{{ $index }}"
                                           value="{{ \App\Models\LegalDocument::STATUS_ACTIVE }}"
                                           name="status"
                                        {{ $legalDocument->status == \App\Models\LegalDocument::STATUS_ACTIVE ? 'checked="checked"' : '' }}
                                    >
                                    <label for="active{{ $index }}"> Active </label>
                                </div>
                                <div class="radio form-check-inline">
                                    <input type="radio" id="inActive{{ $index }}"
                                           value="{{ \App\Models\LegalDocument::STATUS_INACTIVE }}"
                                           name="status"
                                        {{ $legalDocument->status == \App\Models\LegalDocument::STATUS_INACTIVE ? 'checked="checked"' : '' }}
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
                                    <button type="submit" class="btn btn-danger btn-xs"
                                            form="deleteBanner{{ $legalDocument->id }}">
                                        <i class="uil uil-trash-alt"></i> Delete
                                    </button>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
                <form method="post" action="{{ route('admin.legal.destroy', $legalDocument) }}"
                      enctype="multipart/form-data" id="deleteBanner{{ $legalDocument->id }}">
                    @csrf
                    @method('delete')
                </form>
            </div>
        @endforeach
    </div>
@endsection

@include('admin.layouts.filepond')
