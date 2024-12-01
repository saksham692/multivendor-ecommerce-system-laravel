<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
            ->addColumn('action', 'backend.admin.product.dataTable_actions')
            ->editColumn('thumbnail', function ($query) {
                return "<img width='50px' src='" . get_image($query->thumbnail_img) . "' class='rounded-0' alt='Product Thumbnail'>";
            })
            ->editColumn('stock_status', function ($query) {
                switch ($query->stock_status){
                    case 1:
                        return "<span class='badge badge-success rounded-0'>In Stock</span>";
                        break;
                    case 0:
                        return "<span class='badge badge-danger rounded-0'>Out of Stock</span>";
                        break;
                }
            })
            ->editColumn('is_active', function ($query) {
                return "<label class='custom-switch'>
                <input type='checkbox' name='is_active' value='".$query->id."' class='custom-switch-input is_active' ". ($query->is_active == 1 ? 'checked' : '') .">
                <span class='custom-switch-indicator'></span>
            </label>";
            })
            ->rawColumns(['thumbnail', 'stock_status', 'is_active', 'action']) // To handle HTML in columns
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
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
            Column::make('price')->title('Price'),
            Column::make('stock_status')->title('Stock Status'),
            Column::make('is_active')->title('Active'),
            Column::computed('action')->title('Action')->exportable(false)->printable(false)->width(200)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
