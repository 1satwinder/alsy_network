@extends('member.layouts.master')

@section('title') Generate Support Ticket @endsection

@section('content')
    @include('member.breadcrumbs', [
         'crumbs' => [
             'Generate Support Ticket'
         ]
    ])
    <form onsubmit="subButton.disabled = true; return true;" method="post" class="filePondForm"
          action="{{ route('member.support.store') }}">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="message" class="form-control" required
                                               placeholder="Enter your message" autocomplete="off">
                                        <label for="code" class="required">Message</label>
                                    </div>
                                    @foreach($errors->get('message') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" class="filePondInput" name="image" accept="image/*">

                                    @foreach($errors->get('image') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="subButton"
                                    class="btn btn-primary btn-lg waves-effect waves-light">Send
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@include('admin.layouts.filepond')

