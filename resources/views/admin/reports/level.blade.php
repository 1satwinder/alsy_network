@extends('admin.layouts.master')

@section('title')
    Level Report
@endsection

@section('content')
    @include('admin.breadcrumbs', [
'crumbs' => [
' Level Report '
]
])
    <form method="post" action="{{ route('admin.reports.level') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="code" id="code" value="{{ $member?$member->code:'' }}"
                                           class="form-control memberCodeInput" placeholder="Member ID">
                                    <label for="code" class="">Member ID</label>
                                    @foreach($errors->get('code') as $error)
                                        <span class="error text-danger memberName">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-sm-center">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>

                                <a href="{{ route('admin.reports.level') }}"
                                   class="btn btn-danger waves-effect waves-light font-weight-bold">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if(isset($levelDetails) && !empty($levelDetails))
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" dir="ltr">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>
                                        Level
                                    </th>
                                    <th>
                                        Total Members
                                    </th>
                                    <th>
                                        Active Members
                                    </th>
                                    <th>
                                        In-active Members
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($levelDetails as $key => $level)
                                    <tr>
                                    <tr>
                                        <td>
                                            {{ $level['level'] }}
                                        </td>
                                        <td>
                                            {{ $level['teamCount'] }}
                                        </td>
                                        <td>
                                            {{ $level['activeCount'] }}
                                        </td>
                                        <td>
                                            {{ $level['inActiveCount'] }}
                                        </td>
                                        <td>
                                            <a class="btn btn-success btn-sm" target="_blank" href="{{ route('admin.reports.level-detail',[
                                                        'level'=>$level['level'],'memberId' => $member->id
                                                        ]) }}">View Detail
                                            </a>
                                        </td>
                                    </tr>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
