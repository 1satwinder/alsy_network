<div class="btn-group">
    <button type="button" class="btn btn-toggle dropdown-toggle waves-effect shadow-none"
            data-bs-toggle="dropdown" aria-expanded="false">
        <i class="mdi mdi-dots-vertical"></i>
    </button>
    <div class="dropdown-menu">
        @if(!$model->isBlocked())
            @can('Members-update')
                <a class="dropdown-item" href="{{ route('admin.members.edit', $model) }}">
                    <i class="fa-duotone fa-user-pen me-2"></i> Edit
                </a>
                <form action="{{ route('admin.members.impersonate.store', $model) }}" method="post" target="_blank"
                      class="noLoader">
                    @csrf
                    <a href="javascript:void(0)" class="dropdown-item" onclick="$(this).parent('form').submit();">
                        <i class="fa-duotone fa-arrow-right-to-bracket me-2"></i>Login Member
                    </a>
                </form>
                <a class="dropdown-item" href="{{ route('admin.members.change-password.edit', $model) }}">
                    <i class="fa-duotone fa-lock me-2"></i> Change Password
                </a>
                <form action="{{ route('admin.members.block.store', $model) }}" method="post">
                    @csrf
                    <button class="dropdown-item" href="#">
                        <i class="fa-duotone fa-user-slash me-2"></i>&nbsp;Block
                    </button>
                </form>
            @endcan
            @can('Members-read')
                <a class="dropdown-item" href="{{ route('admin.sponsor-genealogy.show', $model) }}">
                    <i class="fa-duotone fa-sitemap me-2"></i> Tree
                </a>
            @endcan
        @else
            @can('Members-update')
                <form action="{{ route('admin.members.block.destroy', $model) }}"
                      method="post">
                    @csrf
                    @method('delete')
                    <button class="dropdown-item" href="#">
                        <i class="fa-duotone fa-user-unlock me-2"></i>&nbsp;UnBlock
                    </button>
                </form>
            @endcan
        @endif
    </div>
</div>
