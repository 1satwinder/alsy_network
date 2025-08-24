@if($model->status === \App\Models\WithdrawalRequest::STATUS_PENDING)
    <div class="checkbox checkbox-primary checkbox-single">
        <input type="checkbox" class="form-check-input" id="singleCheckbox{{ $model->id }}" value="{{ $model->id }}"
               name="withdrawalRequest[]" form="statusChangeForm">
        <label for="singleCheckbox{{$model->id}}"></label>
    </div>
@else
    N/A
@endif
