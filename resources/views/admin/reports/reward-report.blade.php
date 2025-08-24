@extends('admin.layouts.master')

@section('title')
    Reward Report
@endsection

@section('content')
    @include('admin.breadcrumbs', [
       'crumbs' => [
           'Reward Report'
       ]
  ])
    <form method="post" action="{{ route('admin.reports.reward') }}" method="post">
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

                                <a href="{{ route('admin.reports.reward') }}"
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
    @if(isset($rewards) && !empty($rewards))
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" dir="ltr">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped text-nowrap">
                                <thead>
                                <tr>
                                    <th>
                                        Level
                                    </th>
                                    <th>
                                        Required Member
                                    </th>
                                    <th>
                                        Actual Member
                                    </th>
                                    <th>
                                        Remaining Member
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rewards as $record)
                                    <tr>
                                        <td class="text-normal">
                                            {{ $record['level'] }}
                                        </td>
                                        <td>
                                            {{ round($record['requiredMember']) }}
                                        </td>
                                        <td>
                                            {{ round($record['actualMember']) }}
                                        </td>
                                        <td>
                                            {{ round($record['remainingMember']) }}
                                        </td>
                                        <td>
                                            {{ $record['reward'] }}
                                        </td>
                                        <td>
                                             <span class="btn btn-{{$record['statusColor']}} btn-xs waves-effect waves-light">
                                                 {{ $record['status'] }}
                                             </span>
                                        </td>
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
