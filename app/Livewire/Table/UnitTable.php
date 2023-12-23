<?php

namespace App\Livewire\Table;

use App\Models\Unit;
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

final class UnitTable extends PowerGridComponent
{
    use WithExport;

    public $id_asset;

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
        $id_asset = $this->id_asset;

        if ($id_asset === 'all') {
            return Unit::query();
        }

        return Unit::query()->where('asset_id', $id_asset);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('serial_number')

           /** Example of custom column using a closure **/
            ->addColumn('serial_number_lower', fn (Unit $model) => strtolower(e($model->serial_number)))

            ->addColumn('purchase_date_formatted', fn (Unit $model) => Carbon::parse($model->purchase_date)->format('d/m/Y'))
            ->addColumn('location')
            ->addColumn('asset_id')
            ->addColumn('created_at_formatted', fn (Unit $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Serial number', 'serial_number')
                ->sortable()
                ->searchable(),

            Column::make('Purchase date', 'purchase_date_formatted', 'purchase_date')
                ->sortable(),

            Column::make('Location', 'location')
                ->sortable()
                ->searchable(),

            Column::make('Asset id', 'asset_id'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('serial_number')->operators(['contains']),
            Filter::datepicker('purchase_date'),
            Filter::inputText('location')->operators(['contains']),
            Filter::datetimepicker('created_at'),
        ];
    }

    public function actions(\App\Models\Unit $row): array
    {
        return [
            Button::add('delete')
                ->slot('Delete')
                ->id()
                ->class('btn btn-danger')
                ->dispatch('trigger-unit-delete', [$row->id, $row->serial_number])
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
