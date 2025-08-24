<div class="form-check form-check-primary">
    <input class="form-check-input productsCheckBox chk_boxes1" type="checkbox" id="products{{$model->id}}"
           value="{{$model->id}}"
           name="products[{{ $model->id }}][id]" form="statusChangeForm">
    <label class="form-check-label" for="products{{$model->id}}"></label>
</div>
