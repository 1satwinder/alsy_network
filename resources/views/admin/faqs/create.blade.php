@extends('admin.layouts.master')
@section('title','Create FAQs')

@section('content')
    @include('admin.breadcrumbs', [
    'crumbs' => [
        'Create FAQs'
        ]
    ])
    <form action="{{ route('admin.faqs.store') }}" method="post" role="form" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="question" class="form-control" id="question"
                                       value="{{ old('question') }}" placeholder="Enter Question" required>
                                <label for="question" class="required">Question</label>
                            </div>
                            @foreach($errors->get('question') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                               <textarea name="answer" class="form-control h-px-100" id="Answer"
                                         placeholder="Enter Answer" required>{{ old('answer') }}</textarea>
                                <label for="Answer" class="required">Answer</label>
                            </div>
                            @foreach($errors->get('answer') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <button class="btn btn-primary" type="submit"><i class="uil uil-message me-1"></i>
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
