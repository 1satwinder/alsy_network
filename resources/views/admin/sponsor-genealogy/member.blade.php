<div class="hv-item-child">
    @if($level <1)
        <div class="hv-item">
            <div class="hv-item-parent">
                @include('admin.sponsor-genealogy.person', ['member' => $member , 'parent' => $member->sponsor])
            </div>
            <div class="hv-item-children">
                @foreach($member->sponsored()->with('kyc', 'media', 'user', 'package','sponsor.user','currentMagicPoolTrees.magicPoolDetail')->get() as $child)
                    @include('admin.sponsor-genealogy.member', ['member' => $child ?? null,'level' => $level + 1,'parent' => $member])
                @endforeach

                @for($i = 0; $i < 7 - $member->sponsored->count(); $i++)
                    @include('admin.sponsor-genealogy.member', ['member' => null,'level' => $level + 1 , 'parent' => $member])
                @endfor
            </div>
        </div>
    @else
        @include('admin.sponsor-genealogy.person', ['member' => $member])
    @endif
</div>
