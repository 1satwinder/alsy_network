@can('Fund Wallet-update')
    @if ($model->isPending())
        <div class="d-flex">
        <form action="{{ route('admin.fund-requests.approve', $model->id) }}" method="get">
            @csrf
            <button type="button" onclick="confirmPopup(this,'Approve' , 'Fund Request')"
                    class="btn btn-success btn-sm me-2">Approve
            </button>
        </form>

        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#modal{{ $model->id }}">
            Reject
        </button>

        <div class="modal modal-top fade" id="modal{{ $model->id }}" tabindex="-1" style="display: none;"
             aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" action="{{ route('admin.fund-requests.reject',$model) }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTopTitle">Reject Fund Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3 fund-request-remark-div">
                                <label for="remark" class="form-label">Reject Reason</label>
                                <input type="text" name="remark" value="{{old('remark')}}" id="remark"
                                       class="form-control fund-request-remark" placeholder="Enter Reject Reason">
                                <span class="text-danger remarkErrorMsg{{ $model->id }}"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    @else
        N/A
    @endif
@endcan
