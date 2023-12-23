<div>

    @if ($isOpenDetail)
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Add Asset</h5>
                        <button type="button" wire:click='closeModal' class="btn-close" aria-label="Close"></button>
                    </div>
                    <form wire:submit="edit">
                        @csrf
                        <div class="modal-body">

                        @livewire('Table.UnitTable', ['id_asset' => $this->id_asset])

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
