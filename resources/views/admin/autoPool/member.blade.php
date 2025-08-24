<div class="hv-item-child">
    @if($level < 2)
        <div class="hv-item">
            <div class="hv-item-parent">
                @include('admin.autoPool.person', ['autoPoolMember' => $autoPoolMember])
            </div>
            <div class="hv-item-children">
                @if($autoPoolMember)
                    @php $autoPoolMember->load('children'); @endphp
                    @foreach($autoPoolMember->children as $childrenMember)
                        @include('admin.autoPool.member', ['autoPoolMember' => $childrenMember ,'level' => $level + 1 , 'parent' => $autoPoolMember->member])
                    @endforeach
                @endif
                @for($i = ($autoPoolMember ? count($autoPoolMember->children) : 0); $i < 4; $i++)
                    @include('admin.autoPool.member', ['autoPoolMember' => null ,'level' => $level + 1,'parent' => $autoPoolMember ?: null])

                @endfor
            </div>
        </div>
    @else
        @include('admin.autoPool.person', ['autoPoolMember' => $autoPoolMember])
    @endif
</div>
