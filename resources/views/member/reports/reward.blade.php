@extends('member.layouts.master')

@section('title')
    Reward Report
@endsection

@section('content')
    <div class="content-body">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between">
                            <h4 class="card-title mb-0">Reward Report</h4>
                        </div>
                        <div class="card-datatable table-responsive">
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
                                    @foreach($details as $record)
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
                                             <span
                                                     class="btn btn-{{$record['statusColor']}} btn-xs waves-effect waves-light">
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
        </section>
    </div>

@endsection
