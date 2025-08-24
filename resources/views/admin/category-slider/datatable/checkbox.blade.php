{{--@if($model->created_at)--}}
{{--        <span ><input id="checkbox{{$model->id}}" type="checkbox" name="change_status[]" value="{{$model->id}}" /></span>--}}
{{--        <label for="checkbox{{$model->id}}"></label>--}}
{{--@endif--}}

@if($model->created_at)
<div class="form-check form-check-primary mb-0">
    <input class="form-check-input" type="checkbox" id="checkbox{{$model->id}}"
           value="{{ $model->id }}" name="change_status[]"/>
    <label class="form-check-label" for="checkbox{{$model->id}}"></label>
</div>
@endif
