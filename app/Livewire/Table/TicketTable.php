<?php

namespace App\Livewire\Table;

use App\Models\Ticket;
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

final class TicketTable extends PowerGridComponent
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
        return Ticket::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('number')

           /** Example of custom column using a closure **/
            ->addColumn('number_lower', fn (Ticket $model) => strtolower(e($model->number)))

            ->addColumn('user_id')
            ->addColumn('start_date_formatted', fn (Ticket $model) => Carbon::parse($model->start_date)->format('d/m/Y'))
            ->addColumn('end_date_formatted', fn (Ticket $model) => Carbon::parse($model->end_date)->format('d/m/Y'))
            ->addColumn('request_desc')
            ->addColumn('status')
            ->addColumn('action_date_formatted', fn (Ticket $model) => Carbon::parse($model->action_date)->format('d/m/Y'))
            ->addColumn('action_desc')
            ->addColumn('created_at_formatted', fn (Ticket $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Number', 'number')
                ->sortable()
                ->searchable(),

            Column::make('User id', 'user_id'),
            Column::make('Start date', 'start_date_formatted', 'start_date')
                ->sortable(),

            Column::make('End date', 'end_date_formatted', 'end_date')
                ->sortable(),

            Column::make('Request desc', 'request_desc')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status'),
            Column::make('Action date', 'action_date_formatted', 'action_date')
                ->sortable(),

            Column::make('Action desc', 'action_desc')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('number')->operators(['contains']),
            Filter::datepicker('start_date'),
            Filter::datepicker('end_date'),
            Filter::datepicker('action_date'),
            Filter::datetimepicker('created_at'),
        ];
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert('.$rowId.')');
    // }

    public function actions(\App\Models\Ticket $row): array
    {
        return [
            Button::add('approval')
                ->slot('Approval')
                ->id()
                ->class('btn btn-primary')
                ->dispatch('trigger-approval', [$row->id])
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
