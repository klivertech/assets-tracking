<div>

    @if ($isOpenDelete)
        <div class="modal modal-blur modal-show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Delete Category</h5>
                        <button type="button" wire:click='closeModal' class="btn-close" aria-label="Close"></button>
                        <div class="modal-status bg-danger"></div>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pb-4">
                                    <label class="form-label">Are you sure to delete
                                        <b>{{ $this->categoryName }}</b>
                                        ?</label>
                                    <label class="form-label text-danger">by deleting it, assets and units related to this
                                        category
                                        will also be deleted</label>
                                    <input type="text" class="form-control" name="id" id="idAssetDelete" hidden>

                                </div>

                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Asset Name</th>
                                                <th>Total Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($this->assets as $asset)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $asset->name }}</td>
                                                    <td>{{ $asset->total_unit }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click='closeModal'
                            class="btn btn-link link-secondary">Close</button>
                        <button wire:click='delete' class="btn btn-danger ms-auto">Yes, Delete it!</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
