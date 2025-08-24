@extends('member.layouts.master')

@section('title')
    Magic Pool Report
@endsection

@section('content')
    @include('member.breadcrumbs', [
                            'crumbs' => [
                                "Magic Pool Report"
                            ]
                       ])
    @if(isset($details) && !empty($details) && count($details) >0)
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" dir="ltr">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>

                                </thead>
                                <tbody>
                                @foreach($details as $detail)
                                    <tr>
                                        <td>
                                            {{ $detail['name'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Level
                                        </th>
                                        <th>
                                            Required Members
                                        </th>
                                        <th>
                                            Current Members
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $detail['level'] }}
                                        </td>
                                        <td>
                                            {{ $detail['total_member'] }}
                                        </td>
                                        <td>
                                            {{ $detail['current_member'] }}
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-{{$detail['statusColor']}}">{{ $detail['status'] }}</button>
                                        </td>
                                    </tr>
                                    <tr><td colspan="4"></td></tr>
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
