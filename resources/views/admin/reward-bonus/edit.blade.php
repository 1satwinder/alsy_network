@extends('admin.layouts.master')

@section('title')
    Update Reward Bonus Detail:- Level {{ $rewardBonus->level }}
@endsection

@section('content')
    @include('admin.breadcrumbs', [
         'crumbs' => [
             'Update Reward Bonus Detail :- Level '.$rewardBonus->level
         ]
    ])
    <form action="{{ route('admin.reward-bonus.update',$rewardBonus) }}" method="post" enctype="multipart/form-data"
          class="filePondForm">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div id="app">
                            <div class="row">
                                <div class="form-group mb-3 col-lg-4 col-12">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="text" id="reward" class="form-control"
                                               placeholder="Enter Reward Bonus Name"
                                               name="reward"
                                               value="{{ old('reward',$rewardBonus->reward) }}">
                                        <label for="reward" class="required">Reward Bonus Name</label>
                                    </div>
                                    @foreach($errors->get('reward') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="uil uil-message me-1"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('page-javascript')
@endpush
@push('page-css')
@endpush
