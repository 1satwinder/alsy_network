<div class="person genealogy-tree">
    @if($autoPoolMember)
        @php $autoPoolMember->load('member'); @endphp
        <div tabindex="0" data-bs-html="true"
             data-bs-container="body"
             title="{{ $autoPoolMember->member->code }}" data-bs-toggle="popover" data-bs-trigger="{{ Agent::isMobile() ? 'focus' : 'hover'}}"
             data-bs-original-title="{{ $autoPoolMember->member->code }}"
             data-bs-content="@include('admin.autoPool.popover', ['member' => $autoPoolMember->member])">
            @if(Agent::isMobile())
                <img src="{{ $autoPoolMember->member->present()->genealogyImage() }}"
                     alt="{{ $autoPoolMember->member->code }}"
                     style="background-color: {{ $autoPoolMember->member->present()->genealogyImageBackground() }};"
                     onerror="this.src='{{ asset('images/blank.svg') }}'; this.alt='Member Avatar';">
            @else
                <a href="{{ route('admin.autoPool.show',[$magicPool->id, $autoPoolMember->member->code]) }}">
                    <img src="{{ $autoPoolMember->member->present()->genealogyImage() }}"
                         alt="{{ $autoPoolMember->member->code }}"
                         style="background-color: {{ $autoPoolMember->member->present()->genealogyImageBackground() }};"
                         onerror="this.src='{{ asset('images/blank.svg') }}'; this.alt='Member Avatar';">
                </a>
            @endif
        </div>
        <div class="name">
            @if(Agent::isMobile())
                <span>
                    <a href="{{ route('admin.autoPool.show', $autoPoolMember->member) }}">{{ $autoPoolMember->member->user->name }}</a>
                </span>
                <span> @include('copy-text', ['text' => $autoPoolMember->member->code])</span>
            @else
                @php $autoPoolMember->load('member') @endphp
                <span class="d-block">{{ ucwords($autoPoolMember->member->user->name) }}</span>
                <span>@include('copy-text', ['text' => $autoPoolMember->member->code])</span>
            @endif
        </div>
    @else
        <img src="{{ asset('images/add.png') }}"
             alt="Empty" class="" style="background-color: gray">
        <p class="name">
            Empty
        </p>
    @endif
</div>

