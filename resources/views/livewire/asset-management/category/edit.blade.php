<div>

    @if ($isOpenEdit)
        <div class="modal modal-blur fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Add Category</h5>
                        <button type="button" wire:click='closeModal' class="btn-close" aria-label="Close"></button>
                    </div>
                    <form wire:submit="edit">
                        @csrf
                        <div class="modal-body">

                            <input type="text" class="form-control" name="id" id="id" hidden>

                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input wire:model.defer="form.name" type="text" class="form-control" id="name">
                                @error('form.name')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <label class="form-label">Description</label>
                                        <textarea wire:model.defer="form.description" class="form-control" rows="3" name="assetDescription"
                                            id="description"></textarea>
                                        @error('form.description')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click='closeModal'
                                class="btn btn-link link-secondary">Close</button>
                            <button type="submit" class="btn btn-primary ms-auto">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>


