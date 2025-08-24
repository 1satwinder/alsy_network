@extends('member.layouts.master')

@section('title') Videos @endsection

@section('content')
    @include('member.breadcrumbs', [
'crumbTitle' => function () {
    return 'Videos';
},
'crumbs' => [
   'Videos ',
]
])
    <div class="content-body">
        <section id="responsive-datatable">
            @if(isset($videos) && count($videos)>0)
            <div class="row">
                @foreach($videos as $key => $video)
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <p class="video-title ">{{ $video->title }}</p>

                                <a href="{{ $video->link }}" target="_blank">
                                    <iframe width="100%" height="300px"
                                            src="{{ $video->link }}"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                    </iframe>
                                </a>
                                <h3>Description</h3>
                                <p class="video-title ">{{ $video->description }}</p>
                                <div class="modal fade bs-example-modal-center{{ $video->id }}" tabindex="-1"
                                     role="dialog" aria-labelledby="myCenterModalLabel"
                                     aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myCenterModalLabel">
                                                    Social Video Description
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    ×
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @if(isset($video->description))
                                                    {!! $video->description !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
        </section>
    </div>
@endsection

