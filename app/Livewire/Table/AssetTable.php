<?php

namespace App\Livewire\Table;

use App\Models\Asset;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class AssetTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Asset::query()->with('category');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')

           /** Example of custom column using a closure **/
            ->addColumn('name_lower', fn (Asset $model) => strtolower(e($model->name)))

            ->addColumn('total_unit')
            ->addColumn('description')
            ->addColumn('category.name');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Total unit', 'total_unit'),
            Column::make('Description', 'description'),
            Column::make('Category id', 'category.name'),
            Column::action('Action')
        ];
    }


    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert('.$rowId.')');
    // }

    public function actions(\App\Models\Asset $row): array
    {
        return [
            Button::add('detail')
                ->slot('Detail')
                ->id()
                ->class('btn btn-primary')
                // ->route('admin.assetmanagement.units.index', [$row->id]),
                ->dispatch('trigger-asset-detail', [$row->id]),

            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('btn btn-warning')
                ->dispatch('trigger-asset-edit', [$row->id]),

            Button::add('delete')
                ->slot('Delete: '.$row->id)
                ->id()
                ->class('btn btn-danger')
                ->dispatch('trigger-asset-delete', [$row->id, $row->name])

        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
