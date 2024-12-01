<?php

namespace App\DataTables;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn() // Adds serial number column
            ->addColumn('action', 'backend.admin.user.dataTable_actions')
            ->editColumn('user_role', function ($query){
                return ucfirst(optional($query->roles[0])->name);
            })
            ->rawColumns(['action']) // To handle HTML in columns
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->drawCallback('function() {
                // Initialize tooltips
                $(\'[data-toggle="tooltip"]\').tooltip();
            }');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('#') // Serial number column
                ->searchable(false) // Disable search
                ->orderable(false) // Disable ordering
                ->width(30),
            Column::make('name')->title('Name'),
            Column::make('email')->title('Email'),
            Column::make('user_role')->title('Role'),
            Column::computed('action')->title('Action')->exportable(false)->printable(false)->width(200)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
