@extends('admin.layouts.master')

@section('title')
    {{ $magicPool->name }}
@endsection

@section('content')
    @include('admin.breadcrumbs', [
    'crumbs' => [
          $magicPool->name
    ]
])
    <form>
        <div class="row">
            <div class="col-12">
                <div class="row mb-4 d-flex justify-content-center">
                    <div class="col-sm-4 col-12">
                        <div class="form-group mb-2">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="code" class="form-control" placeholder="Search By Member ID"
                                           required>
                                    <label for="code">Member ID</label>
                                </div>
                                <span class="input-group-text">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                        onclick="goToMember()">Search</button>
                                            </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5 d-flex justify-content-center text-center tree genealogy-tree">
                    {{--                    <div class="col">--}}
                    {{--                        <img src="{{ asset('images/free-id.svg') }}" class="rounded-circle avatar-md" alt="">--}}
                    {{--                        <p>Free</p>--}}
                    {{--                    </div>--}}
                    @foreach($genealogyIcons as $genealogyIcon)
                        <div class="col">
                            <img src="{{ asset($genealogyIcon['image']) }}"
                                 class="rounded-circle avatar-md" alt=""
                                 style="background-color: {{ $genealogyIcon['color'] }}">
                            <p>{{ ucfirst($genealogyIcon['name']) }}</p>
                        </div>
                    @endforeach
                </div>
                @if($autoPoolMember)
                    <section class="management-hierarchy d-flex justify-content-center text-center">
                        <div class="hv-container">
                            <div class="hv-wrapper">
                                @include('admin.autoPool.member', ['autoPoolMember' => $autoPoolMember , 'level' => 0])
                            </div>
                        </div>
                    </section>
                @else
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="text-center">
                                <h3 class="mt-4">You are not eligible</h3>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
@endsection
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/genealogy-tree.css') }}">
    <style>
        @media (max-width: 767.98px) {
            .hv-wrapper {
                display: flex;
            }

            .hv-wrapper .hv-item .hv-item-children {
                justify-content: flex-start !important;
            }
        }

        .hv-wrapper {
            display: block;
        }

        .hv-wrapper .hv-item .hv-item-children {
            justify-content: flex-start !important;
        }
    </style>
@endpush

@push('page-javascript')
    <script src="{{ asset('js/genealogy-fallback.js') }}"></script>
    <script>
        function goToMember() {
            var trackingCode = $('#code').val();
            if (trackingCode.length) {
                window.location = '{{ route('admin.autoPool.show',$magicPool) }}/' + trackingCode;
            }
        }

        $('form').submit(function (e) {
            e.preventDefault();
            goToMember();
        });
    </script>
@endpush
