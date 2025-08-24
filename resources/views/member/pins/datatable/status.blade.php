@if($model->isUsed())
    <span class="btn btn btn-warning btn-sm waves-effect waves-float waves-light">
        Used
    </span>
@elseif($model->isUnUsed())
    <span class="btn btn-success btn-sm waves-effect waves-float waves-light">
        Unused
    </span>
@elseif($model->isBlocked())
    <span class="btn btn-dark btn-sm waves-effect waves-float waves-light">
        Blocked
    </span>
@endif
@if($model->isUnUsed())
    <a href="{{ route('member.topups.create',['pin'=> $model->code]) }}"
       class="btn btn-primary btn-sm waves-effect waves-float waves-light">
        Make Topup
    </a>
@endif
