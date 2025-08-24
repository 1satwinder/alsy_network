<div class="person">
    @if($member)
        <div tabindex="0" data-bs-html="true"
             data-bs-container="body"
             title="{{ $member->code }}" data-bs-toggle="popover" data-bs-trigger="{{ Agent::isMobile() ? 'focus' : 'hover'}}"
             data-bs-original-title="{{ $member->code }}"
             data-bs-content="@include('member.genealogy.popover', ['member' => $member])">
            @if(Agent::isMobile())
                <img src="{{ $member->present()->genealogyImage() }}"
                     alt="{{ $member->code }}"
                     style="background-color: {{ $member->present()->genealogyImageBackground() }};">
            @else
                <a href="{{ route('member.genealogy.show', $member) }}">
                    <img src="{{ $member->present()->genealogyImage() }}"
                         alt="{{ $member->code }}"
                         style="background-color: {{ $member->present()->genealogyImageBackground() }};">
                </a>
            @endif
        </div>
        <div class="name">
            @if(Agent::isMobile())
                <span>
                    <a href="{{ route('member.genealogy.show', $member) }}">{{ $member->user->name }}</a>
                </span>
                <span>@include('copy-text', ['text' => $member->code])</span>
            @else
                <span class="d-block">{{ ucwords($member->user->name) }}</span>
                <span>@include('copy-text', ['text' => $member->code])</span>
            @endif
        </div>
    @else
        <a href="{{ $parent ? route('member.register.create', ['code' => Auth::user()->member->code, 'side' => $side]) : 'javascript::void(0);' }}" {{ $parent ? 'target="_blank"' : '' }}>
            <img src="{{ asset('images/add.png') }}"
                 alt="Empty" class="" style="background-color: gray">
        </a>
        <p class="name">
            Empty
        </p>
    @endif
</div>
