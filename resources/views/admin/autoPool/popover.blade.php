<div class='row'>
    <div class='col-6 mb-3'><h6 class='text-primary font-weight-600 text-uppercase mb-1'>Joining Date :</h6>
        <p class='mb-1'> {{  $autoPoolMember->member->created_at->dateFormat()  }}</p>
    </div>
    <div class='col-6 mb-3'><h6 class='text-primary font-weight-600 text-uppercase mb-1'>Activation Date :</h6>
        <p class='mb-1'>{{ optional($autoPoolMember->member->activated_at)->dateFormat() }}</p>
    </div>
    <div class='col-6 mb-3'><h6 class='text-primary font-weight-600 text-uppercase mb-1'>Package :</h6>
        <p class='mb-1'>
            {{ optional($autoPoolMember->member->package)->name }} Autopool
            <br/>({{ trim(env('APP_CURRENCY')) }} {{ round(optional($autoPoolMember->member->package)->amount,4) }})
        </p>
    </div>
    <div class='col-6 mb-3'><h6 class='text-primary font-weight-600 text-uppercase mb-1'>Sponsor ID :</h6>
        <p class='mb-1'>
            {{$autoPoolMember->member->sponsor ? $autoPoolMember->member->sponsor->code:'--'}}
        </p>
    </div>
    <div class='col-6 mb-3'><h6 class='text-primary font-weight-600 text-uppercase mb-1'>Sponsor Name :</h6>
        <p class='mb-1'>
            {{$autoPoolMember->member->sponsor ? $autoPoolMember->member->sponsor->user->name:'--'}}
        </p>
    </div>
    @php $autoPoolMember->load('parent'); @endphp
    @if($autoPoolMember->parent)
        <div class='col-6 mb-3'><h6 class='text-primary font-weight-600 text-uppercase mb-1'>Parent ID :</h6>
            <p class='mb-1'>
                {{$autoPoolMember->parent->member ? $autoPoolMember->parent->member->code:'--'}}
            </p>
        </div>
        <div class='col-6 mb-3'><h6 class='text-primary font-weight-600 text-uppercase mb-1'>Parent Name :</h6>
            <p class='mb-1'>
                {{$autoPoolMember->parent->member ? $autoPoolMember->parent->member->user->name:'--'}}
            </p>
        </div>
    @endif
</div>
