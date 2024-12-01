<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
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
            ->addColumn('action', 'backend.admin.product.category.dataTable_actions')
            ->editColumn('thumbnail', function ($query) {
                return "<img width='50px' src='" . get_image($query->thumbnail_img) . "' class='rounded-0' alt='Category Thumbnail'>";
            })
            ->editColumn('parent_id', function ($query) {
                return optional($query->parent)->name;
            })
            ->editColumn('icon', function ($query) {
                return "<i style='font-size:40px' class='".$query->icon."'></i>";
            })
            ->editColumn('is_active', function ($query) {
                return "<label class='custom-switch'>
                <input type='checkbox' name='is_active' value='".$query->id."' class='custom-switch-input is_active' ". ($query->is_active == 1 ? 'checked' : '') .">
                <span class='custom-switch-indicator'></span>
            </label>";
            })
            ->rawColumns(['thumbnail', 'icon', 'is_active', 'action']) // To handle HTML in columns
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('category-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0); // Sort by the first column (ID or S/N)
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
            Column::make('thumbnail')->title('Thumbnail')->width(40),
            Column::make('name')->title('Name'),
            Column::make('parent_id')->title('Parent'),
            Column::make('icon')->title('Icon'),
            Column::make('is_active')->title('Active'),
            Column::computed('action')->title('Action')->exportable(false)->printable(false)->width(200)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }
}
