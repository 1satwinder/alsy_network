<div class='row'>
    <div class='col-12'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-3'>Joining Date :
            <span class='mb-1 text-dark'> {{  $member->created_at->dateFormat()  }}</span>
        </h6>
    </div>
    <div class='col-12'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-3'>Activation Date :
            <span class='mb-1 text-dark'>{{ optional($member->activated_at)->dateFormat() }}</span>
        </h6>
    </div>
    <div class='col-12'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-3'>Package :
            <span class='mb-1 text-dark'>
            {{ optional($member->package)->name }} ({{ env('APP_CURRENCY', ' र ') }}{{ optional($member->package)->amount }})
        </span>
        </h6>
    </div>
    <div class='col-12'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-3'>Members(L/R) :
            <span class='mb-1 text-dark'> {{ $member->left_count }} / {{$member->right_count}}</span>
        </h6>
    </div>
    <div class='col-12'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-3'>Total PV(L/R) :
            <span class='mb-1 text-dark'> {{ $member->left_pv }} / {{ $member->right_pv }}</span>
        </h6>
    </div>
    <div class='col-12'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-3'>Remaining PV(L/R) :
            <span class='mb-1 text-dark'> {{ $member->left_power }} / {{ $member->right_power }}</span>
        </h6>
    </div>
</div>
