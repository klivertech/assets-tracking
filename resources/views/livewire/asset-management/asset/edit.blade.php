<div>

    @if ($isOpenEdit)
        <div class="modal modal-blur fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Add Asset</h5>
                        <button type="button" wire:click='closeModal' class="btn-close" aria-label="Close"></button>
                    </div>
                    <form wire:submit="edit">
                        @csrf
                        <div class="modal-body">

                            <input type="text" class="form-control" name="id" id="id" hidden>

                            {{-- <div class="mb-3">
                                <div class="form-label">Category</div>
                                <input wire:model.defer="form.category_id" class="form-control" name="categoryId"
                                    id="form.category_id" style="width: 100%">
                                </select>
                            </div> --}}

                            <div class="mb-3">
                                <label class="form-label">Category Edit</label>
                                <div wire:ignore>
                                    <select wire:model.defer="form.category_id" class="form-select" id="category_id" name="category">
                                        @foreach ($categories as $category)
                                            <option value={{ $category->id }} wire:key="cat - {{ $category->id }}">
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Asset Name</label>
                                <input wire:model.defer="form.name" type="text" class="form-control" id="name">
                                @error('form.name')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="mb-3">
                        <label class="form-label">Purchase Date</label>
                        <input type="date" class="form-control" name="assetPurchaseDate" id="assetPurchaseDate">
                    </div> --}}
                            <div class="mb-3">
                                <label class="form-label">Total Unit</label>
                                <input wire:model.defer="form.total_unit" type="number" class="form-control"
                                    name="assetTotalUnit" id="total_unit" disabled>
                                @error('form.total_unit')
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


