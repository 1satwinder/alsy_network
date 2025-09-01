@extends('admin.layouts.master')
@section('title')
    Member Popup
@endsection

@section('content')
    @include('admin.breadcrumbs', [
          'crumbs' => [
              'Member Popup'
          ]
     ])
    <div class="row">
        <div class="col-lg-4">
            <form method="post" onsubmit="subButton.disabled = true; return true;"
                  action="{{ route('admin.member-pop.store') }}" class="filePondForm">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="PopupType">
                            <div class="form-group">
                                <label for="Package" class="required">Popup Type</label><br>
                                <div class="form-check form-check-inline mt-1">
                                    <input class="form-check-input popup_type" type="radio"
                                           name="popup_type"
                                           id="self"
                                           value="{{\App\Models\MemberPopup::TYPE_IMAGE}}"
                                           {{ old('popup_type',request()->get('popup_type')) == \App\Models\MemberPopup::TYPE_IMAGE ? 'checked' : '' }}
                                           {{ request()->get('popup_type') ? 'disabled' : '' }} checked
                                           required>
                                    <label class="form-check-label" for="self">Image</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input popup_type" type="radio"
                                           name="popup_type"
                                           id="other"
                                           value="{{\App\Models\MemberPopup::TYPE_VIDEO}}"
                                           {{ old('popup_type',request()->get('popup_type')) == \App\Models\MemberPopup::TYPE_VIDEO ? 'checked' : '' }}
                                           {{ request()->get('popup_type') ? 'disabled' : '' }} required>
                                    <label class="form-check-label" for="other">Video</label>
                                </div>
                                @foreach($errors->get('popup_type') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                        <label class="header-title">Add Popup </label>
                        <div class="form-group mb-3 imageBlock">
                            <input type="file" class="filePondInput" name="image" accept="image/*"/>
                            @foreach($errors->get('image') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <div class="form-group mb-3 linkBlock" style="display: none">
                            <input type="text" name="link" id="link" class="form-control"
                                   placeholder="Enter Youtube Link"
                                   value="{{ old('link') }}">
                            @foreach($errors->get('link') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" required name="name" id="name"
                                       placeholder="Enter Popup Name"/>
                                <label for="name" class="required">Popup Name</label>
                            </div>
                            @foreach($errors->get('name') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        @can('Website Settings-create')
                            <div class="form-group mb-0">
                                <div class="d-flex justify-content-around">
                                    <button name="subButton" type="submit" class="btn btn-primary">
                                        <i class="uil uil-message me-1"></i> Submit
                                    </button>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </form>
        </div>
        @foreach($popups as $index => $popup)
            <div class="col-lg-4">
                <form method="post" onsubmit="subButton{{$index}}.disabled = true; return true;"
                      action="{{ route('admin.member-pop.update', $popup) }}"
                      class="filePondForm">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="header-title required">Popup: #{{ $index + 1 }}</h5>
                            <div class="form-group">
                                <label for="Package" class="required">Popup Type</label><br>
                                <div class="form-check form-check-inline mt-1">
                                    <input class="form-check-input popup_type{{$index + 1}}" type="radio"
                                           name="popup_type"
                                           id="image"
                                           value="{{\App\Models\MemberPopup::TYPE_IMAGE}}"
                                           {{ old('popup_type') == \App\Models\MemberPopup::TYPE_IMAGE ? 'checked' : '' }}
                                           {{ request()->get('popup_type') ? 'disabled' : '' }}
                                           {{$popup->getFirstMediaUrl(\App\Models\MemberPopup::MEDIA_COLLECTION_IMAGE_MEMBER_POPUP) ? 'checked' : ''}}
                                           disabled>
                                    <label class="form-check-label" for="image">Image</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input popup_type{{$index + 1}}" type="radio"
                                           name="popup_type"
                                           id="video"
                                           value="{{\App\Models\MemberPopup::TYPE_VIDEO}}"
                                           {{ old('popup_type',$popup->link) == \App\Models\MemberPopup::TYPE_VIDEO ? 'checked' : '' }}
                                           {{$popup->link ? 'checked' : ''}}
                                           disabled>
                                    <label class="form-check-label" for="video">Video</label>
                                </div>
                                @foreach($errors->get('popup_type') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            @if($popup->getFirstMediaUrl(\App\Models\MemberPopup::MEDIA_COLLECTION_IMAGE_MEMBER_POPUP))
                                <div class="form-group mb-3">
                                    <input type="file" class="filePondInput" name="image" accept="image/*"
                                           data-url="{{ $popup->getFirstMediaUrl(\App\Models\MemberPopup::MEDIA_COLLECTION_IMAGE_MEMBER_POPUP) }}"/>
                                    @foreach($errors->get("image") as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            @endif
                            @if($popup->link)
                                <div class="form-group mb-3">
                                    <input type="text" name="links" id="link" class="form-control"
                                           placeholder="Enter Youtube Link"
                                           value="{{ old('link',$popup->link) }}">
                                    @foreach($errors->get("links") as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="form-group mb-3">
                                <label>Popup Name</label>
                                <input type="text" class="form-control" name="name"
                                       placeholder="Enter popup name"
                                       value="{{ $popup->name }}"/>
                                @foreach($errors->get("name") as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group mb-3 d-flex justify-content-around">
                                <div class="radio radio-info form-check-inline ">
                                    <input type="radio" id="active{{ $index }}"
                                           value="{{ \App\Models\MemberPopup::STATUS_ACTIVE }}"
                                           name="status"
                                        {{ $popup->status == \App\Models\MemberPopup::STATUS_ACTIVE ? 'checked="checked"' : '' }}
                                    >
                                    <label for="active{{ $index }}"> Active </label>
                                </div>
                                <div class="radio form-check-inline">
                                    <input type="radio" id="inActive{{ $index }}"
                                           value="{{ \App\Models\MemberPopup::STATUS_INACTIVE }}"
                                           name="status"
                                        {{ $popup->status == \App\Models\MemberPopup::STATUS_INACTIVE ? 'checked="checked"' : '' }}
                                    >
                                    <label for="inActive{{ $index }}"> Inactive </label>
                                </div>
                                @foreach($errors->get("status") as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group mb-0">
                                <div class="d-flex justify-content-around">
                                    <button type="submit" name="subButton{{$index}}"
                                            class="btn btn-primary">
                                        <i class="uil uil-image-edit"></i> Update
                                    </button>
                                    <button type="submit" class="btn btn-danger"
                                            form="deleteBanner{{ $popup->id }}">
                                        <i class="uil uil-trash-alt"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form method="post" action="{{ route('admin.member-pop.destroy', $popup) }}"
                      enctype="multipart/form-data" id="deleteBanner{{ $popup->id }}">
                    @csrf
                    @method('delete')
                </form>
            </div>
        @endforeach
    </div>
@endsection
@include('admin.layouts.filepond')

@push('page-javascript')
    <script>
        $(document).ready(function () {
            if ('{{ old('popup_type') == '2' }}') {
                $('.linkBlock').css('display', 'block');
                $('.imageBlock').css('display', 'none');
                $("#link").prop('required', true);
            } else {
                $('.linkBlock').css('display', 'none');
                $('.imageBlock').css('display', 'block');
                $("#image").prop('required', false);
            }
        });

        $('.popup_type').change(function () {
            var popUpType = $(this).val();
            if (popUpType == 2) {
                $('.linkBlock').css('display', 'block');
                $('.imageBlock').css('display', 'none');
                $("#link").prop('required', true);
            } else {
                $('.linkBlock').css('display', 'none');
                $('.imageBlock').css('display', 'block');
                $("#image").prop('required', false);
            }
        })
    </script>
@endpush


