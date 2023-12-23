<div>
    <div class="card">
        <div class="card-body border-bottom py-3">
            <div class="d-flex">
                <div class="text-muted">
                    Show
                    <div class="mx-2 d-inline-block">
                        <select wire:model.live = "show" class="form-select">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                          </select>
                    </div>
                    entries
                </div>
                <div class="ms-auto text-muted">
                    Search:
                    <div class="ms-2 d-inline-block">
                        <input wire:model.live = "search" type="text" class="form-control" aria-label="Search">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
    <div id="table-default" class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th wire:click="setSortBy('name')">Name</th>
                    <th wire:click="setSortBy('category_id')">Category</th>
                    <th wire:click="setSortBy('total_unit')">Total Unit</th>
                    <th wire:click="setSortBy('description')">Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-tbody">
                @foreach ($assets as $asset)
                <tr>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->category->name }}</td>
                    <td>{{ $asset->total_unit }}</td>
                    <td>{{ $asset->description }}</td>
                    <td>
                        <button wire:click="$dispatch('trigger-asset-edit', { id: {{ $asset->id }} })">
                            EditPost
                        </button>
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
        {{ $assets->links() }}
    </div>

        </div>
    </div>

</div>
