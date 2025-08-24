@extends('member.layouts.master')

@section('title')
    Reward Achivers
@endsection

@section('content')
    @include('member.breadcrumbs', [
          'crumbs' => [
              'Reward Achievers'
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
                                            <th>#</th>
                                            <th>
                                                Name
                                            </th>
                                            <th>
                                                Image
                                            </th>
                                            <th>
                                                Reward
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $index => $record)
                                            <tr>
                                                <td>{{ $records->firstItem() + $index }}</td>
                                                <td>
                                                    {{ $record->member->user->name }}
                                                </td>
                                                <td>
                                                    <img src="{{ $record->member->present()->profileImage() }}"
                                                         alt="avatar" height="30px"
                                                         class="rounded">
                                                </td>
                                                <td>
                                                    {{ $record->reward }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="float-right">
                                        {{ $records->links("pagination::bootstrap-4")}}
                                    </div>
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
                                            <span class="text-body">No Data Found</span>
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
