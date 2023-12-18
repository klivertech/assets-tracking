<div>


    @if ($isOpenDeleteUnit)
        <div class="modal modal-blur d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Delete Unit</h5>
                        <button type="button" wire:click='closeModalDeleteUnit' class="btn-close" aria-label="Close"></button>
                        <div class="modal-status bg-danger"></div>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pb-4">
                                    <label class="form-label">Are you sure to delete
                                        <b>{{ $this->serialNumber }}</b>
                                        ?</label>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click='closeModalDeleteUnit'
                            class="btn btn-link link-secondary">Close</button>
                        <button wire:click="delete" class="btn btn-danger ms-auto">Yes, Delete</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
