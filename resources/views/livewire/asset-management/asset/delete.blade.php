<div>

    @if ($isOpenDelete)
        <div class="modal modal-blur fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Delete Asset</h5>
                        <button type="button" wire:click='closeModal' class="btn-close" aria-label="Close"></button>
                        <div class="modal-status bg-danger"></div>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pb-4">
                                    <label class="form-label">Are you sure to delete
                                        <b>{{ $this->assetName }}</b>
                                        ?</label>
                                    <label class="form-label text-danger">by deleting it, units related to this
                                        asset
                                        will also be deleted</label>
                                    <input type="text" class="form-control" name="id" id="idAssetDelete" hidden>

                                </div>

                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Serial Number</th>
                                                <th>Location</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($this->units as $unit)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $unit->serial_number }}</td>
                                                    <td>{{ $unit->location }}</td>
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
