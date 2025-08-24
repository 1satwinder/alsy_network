@extends('admin.layouts.master')
@section('title','Update FAQs')

@section('content')
    @include('admin.breadcrumbs', [
    'crumbs' => [
        'Update FAQs'
        ]
    ])
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('admin.faqs.update', $faq)}}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="status" class="form-control" id="statusFaqs" data-toggle="select2">

                                            <option value="1" {{ old('status',$faq->status) == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="2" {{ old('status',$faq->status) == 2 ? 'selected' : '' }}>
                                                In-Active
                                            </option>
                                    </select>
                                    <label for="statusFaqs">Status</label>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="question" name="question" class="form-control" value="{{ old('question',$faq->question) }}"
                                           placeholder="Enter Question" required="">
                                    <label for="question" class="required">Question</label>
                                </div>
                                @foreach($errors->get('question') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-12">
                                <div class="form-floating form-floating-outline">
                               <textarea name="answer" class="form-control h-px-100" id="Answer"
                                         placeholder="Enter Answer" required>{{ old('answer',$faq->answer) }}</textarea>
                                    <label for="Answer" class="required">Answer</label>
                                </div>
                                @foreach($errors->get('answer') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-md-12 text-center">
                                <button class="btn btn-primary" type="submit">
                                    <i class="uil uil-message me-1"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
