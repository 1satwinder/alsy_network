<div class='row'>
    <div class='col-6 mb-3'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-1'>Joining Date :</h6>
        <p class='mb-1'> {{  $member->created_at->dateFormat()  }}</p>
    </div>
    <div class='col-6 mb-3'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-1'>Activation Date :</h6>
        <p class='mb-1'>{{ optional($member->activated_at)->dateFormat()??'--' }}</p>
    </div>
    <div class='col-6 mb-3'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-1'>Sponsor ID :</h6>
        <p class='mb-1'>{{ optional($member->sponsor)->code ?? 'N/A'}}</p>
    </div>
    <div class='col-6 mb-3'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-1'>Sponsor Name :</h6>
        <p class='mb-1'>{{ optional($member->sponsor)->user->name ?? 'N/A'}}</p>
    </div>
    <div class='col-6 mb-3'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-1'>Package :</h6>
        <p class='mb-1'>
            @if($member->package){{ optional($member->package)->name }}<br/>
            (Rs. {{ optional($member->package)->amount }})
            @else
                --
            @endif
        </p>
    </div>
    <div class='col-6 mb-3'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-1'>Direct :</h6>
        <p class='mb-0'> {{ $member->sponsored_count }} </p>
    </div>
    <div class='col-6 mb-3'>
        <h6 class='text-primary font-weight-600 text-uppercase mb-1'>Current Pool :</h6>
        <p class='mb-0'> {{ optional($member->currentMagicPoolTrees)->magicPoolDetail->name ?? 'N/A' }} </p>
    </div>
</div>
