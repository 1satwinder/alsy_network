@if($model->status == \App\Models\Pin::STATUS_UN_USED)
    <div class="form-check mb-1">
        <input type="checkbox" class="form-check-input pinCheckBox" id="pins{{ $model->id }}"
               value="{{ $model->code }}" name="pins[]" form="pinTransferForm">
        <label class="form-check-label" for="pins{{ $model->id }}"></label>
    </div>
@endif
