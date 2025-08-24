@extends('admin.layouts.master')

@section('title')
    Genealogy Tree
@endsection

@section('content')
    @include('admin.breadcrumbs', [
       'crumbs' => [
           'Genealogy Tree'
       ]
   ])
    <form>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row mb-4 d-flex justify-content-center">
                                    <div class="col-sm-4 col-12">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="code" class="form-control"
                                                       placeholder="Search By Member ID" required>
                                                <label for="code">Member ID</label>
                                            </div>
                                            <span class="input-group-text">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                        onclick="goToMember()">Search</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5 d-flex justify-content-center text-center tree">
                                    @foreach($genealogyIcons as $genealogyIcon)
                                        <div class="col">
                                            <img src="{{ asset($genealogyIcon['image']) }}"
                                                 class="rounded-circle avatar-md" alt=""
                                                 style="background-color: {{ $genealogyIcon['color'] }}">
                                            <p>{{ $genealogyIcon['name'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row miniReports">
                                    <div class="col-md-3 col-6">
                                        <h6 class="font-weight-600">DIRECT LEFT
                                            : {{ $member->sponsored_left }}</h6>
                                        <h6 class="font-weight-600">LEFT PV : {{ $member->left_pv }}</h6>
                                        <h6 class="font-weight-600">LEFT POWER
                                            : {{ $member->left_power }}</h6>
                                        <h6 class="font-weight-600">TOTAL LEFT
                                            : {{ $member->left_count }}</h6>
                                    </div>
                                    <div class="offset-md-6 col-md-3 col-6 text-right">
                                        <h6 class="text-blue font-weight-600">DIRECT RIGHT
                                            : {{ $member->sponsored_right }}</h6>
                                        <h6 class="font-weight-600">RIGHT PV: {{ $member->right_pv }}</h6>
                                        <h6 class="font-weight-600">RIGHT
                                            POWER: {{ $member->right_power }}</h6>
                                        <h6 class="font-weight-600">TOTAL RIGHT
                                            : {{ $member->right_count }}</h6>
                                    </div>
                                </div>
                                <section class="management-hierarchy">
                                    <div class="hv-container">
                                        <div class="hv-wrapper">
                                            @include('admin.genealogy.member', ['member' => $member, 'level' => 0])
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('page-javascript')
    <script>
        function goToMember() {
            var trackingCode = $('#code').val();
            if (trackingCode.length) {
                window.location = '{{ route('admin.genealogy.show') }}/' + trackingCode;
            }
        }

        $('form').submit(function (e) {
            e.preventDefault();
            goToMember();
        });

    </script>
@endpush
