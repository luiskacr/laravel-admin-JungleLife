<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Customer $customer){
                $showDelete = auth()->user()->hasRole('Administrador')
                    ? '<a class="m-2" href="#" onclick="deleteItem('.$customer->id.', \''.$customer->name.'\', \''.csrf_token().'\', \''.route('clients.destroy', 0).'\',\''. __('app.customer_single') .'\')">
                                    <i class="bx bx-trash me-1"></i>'.__('app.crud_delete').'</a>'
                    : '';

                return ' <div class="justify-content-between">
                                <a class="m-2" href="'. route('clients.show',$customer->id) .'"><i class="bx bxs-show me-1"></i>'.__('app.crud_show').'</a>
                                <a class="m-2" href="'.route('clients.edit',$customer->id).'"><i class="bx bx-edit-alt me-1"></i>'.__('app.crud_edit').'</a>
                                '.$showDelete.'
                            </div>';
            })
            ->addColumn(__('app.name'), function (Customer $customer){
                return $customer->name;
            })
            ->addColumn(__('app.email'), function (Customer $customer){
                return $customer->email;
            })
            ->addColumn(__('app.telephone'), function (Customer $customer){
                return $customer->telephone;
            })
            ->addColumn(__('app.type_client_singular'), function (Customer $customer){
                return $customer->clientTypes->name ;
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Customer $model
     * @return QueryBuilder
     */
    public function query(Customer $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id','desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return HtmlBuilder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('customer-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make( __('app.name'), 'name'),
            Column::make( __('app.email'), 'email'),
            Column::make( __('app.telephone'), 'telephone'),
            Column::make( __('app.type_client_singular')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Customer_' . date('YmdHis');
    }
}
