<div class="person mb-2">
    @if($member)
        <div tabindex="0" data-bs-html="true"
             data-bs-container="body"
             title="{{ $member->code }}" data-bs-toggle="popover" data-bs-trigger="{{ Agent::isMobile() ? 'focus' : 'hover'}}"
             data-bs-original-title="{{ $member->code }}"
             data-bs-content="@include('admin.sponsor-genealogy.popover', ['member' => $member])">
            @if(Agent::isMobile())
                <img src="{{ $member->present()->genealogyImage() }}"
                     alt="{{ $member->code }}"
                     style="background-color: {{ $member->present()->genealogyImageBackground() }};">
            @else
                <a href="{{ route('admin.sponsor-genealogy.show', $member) }}">
                    <img src="{{ $member->present()->genealogyImage() }}"
                         alt="{{ $member->code }}"
                         style="background-color: {{ $member->present()->genealogyImageBackground() }};">
                </a>
            @endif
        </div>
        <p class="name">
            @if(Agent::isMobile())
                <span>
                    <a href="{{ route('admin.sponsor-genealogy.show', $member) }}">{{ $member->user->name }}</a>
                </span>
                <span>@include('copy-text', ['text' => $member->code])</span>
            @else
                <span class="d-block">{{ ucwords($member->user->name) }}</span>
                <span>@include('copy-text', ['text' => $member->code])</span>
            @endif
        </p>
    @else
        <a href="{{ $parent ? route('member.register.create', ['code' => $parent->code]) : 'javascript::void(0);' }}" {{ $parent ? 'target="_blank"' : '' }} >
            <img src="{{ asset('images/blank.svg') }}"
                 alt="Empty" class="" style="background-color: gray">
        </a>
        <p class="name">
            Empty
        </p>
    @endif
</div>
