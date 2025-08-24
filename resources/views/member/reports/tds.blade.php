@extends('member.layouts.master')

@section('title') TDS Report @endsection

@section('content')
    @include('member.breadcrumbs', [
          'crumbs' => [
              'TDS Report'
          ]
     ])
    <div class="content-body">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if(isset($records) && count($records)>0)
                        <div class="card-datatable table-responsive">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>
                                            Month
                                        </th>
                                        <th>
                                            PAN No
                                        </th>
                                        <th>
                                            TDS ({{env('APP_CURRENCY', ' र ')}})
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($records as $record)
                                        <tr>
                                            <td>
                                                {{ $record->monthYear }}
                                            </td>
                                            <td>
                                                {{ Auth::user()->member->kyc ? Auth::user()->member->kyc->pan_card : '---' }}
                                            </td>
                                            <td>
                                                {{ $record->gst }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @else
                            <div class="col-lg-12 d-flex text-center justify-content-center">
                                <div class="error-content">
                                    <img class="img-fluid"
                                         src="{{ asset('images/empty_item.svg') }}" alt="no-data">
                                    <div class="notfound-404">
                                        <h1 class="text-primary">
                                            <i class="uil uil-sad-squint"></i> Oops!
                                            <span class="text-body">No TDS Data Found</span>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
