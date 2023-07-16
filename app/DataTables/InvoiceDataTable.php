<?php

namespace App\DataTables;

use App\Models\Configuration;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvoiceDataTable extends DataTable
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
            ->addColumn('action', function (Invoice $invoice){
                $config = Configuration::findOrFail(4);
                $edit = '';
                if($invoice->state == 1){
                    $edit = '<a class="m-2" href="'.route('invoice.edit',$invoice->id).'"><i class="bx bx-edit-alt me-1"></i>'.__('app.crud_edit').'</a>';
                }

                return '<div class="justify-content-between">
                                <a class="m-2" href="'.route('invoice.show',$invoice->id).'"><i class="bx bxs-show me-1"></i>'.__('app.crud_show').'</a>
                                '.$edit .'
                                <a class="m-2" target="_blank" rel="noopener" href="'.route('invoice.show-invoice',$invoice->id).'"> <i class="bx bx-file-blank me-1"></i>'.__('app.invoice_btn_show').'</a>
                                <a class="m-2" href="#" onclick="sendInvoice(\''.route('invoice.send-invoice',$invoice->id).'\')" ><i class="bx bx-mail-send me-1"></i>'.__('app.invoice_btn_send').'</a>
                                <a class="m-2" href="#" onclick="deleteItem('.$invoice->id.', \''.$config->data['value'] . $invoice->id.'\', \''.csrf_token().'\', \''.route('invoice.destroy', 0).'\',\''. __('app.invoice') .'\')">
                                    <i class="bx bx-trash me-1"></i>'.__('app.crud_delete').'</a>
                            </div>';
            })
            ->addColumn(__('app.invoice'), function (Invoice $invoice){
                $config = Configuration::findOrFail(4);
                return $config->data['value'] . $invoice->id;
            })
            ->addColumn(__('app.customer_single'), function (Invoice $invoice){
                return $invoice->getClient->name;
            })
            ->addColumn(__('app.date'), function (Invoice $invoice){
                return Carbon::make($invoice->date)->format('d-m-Y');
            })
            ->addColumn(__('app.type'), function (Invoice $invoice){
                return  $invoice->getType->name;
            })
            ->addColumn(__('app.state'), function (Invoice $invoice){
                return  $invoice->getState->name;
            })
            ->addColumn(__('app.money_type'), function (Invoice $invoice){
                return  $invoice->getMoney->name ;
            })
            ->addColumn(__('app.total'), function (Invoice $invoice){
                return  $invoice->getMoney->symbol . $invoice->total ;
            })
            ->filterColumn(__('app.customer_single'), function ($query, $keyword) {
                $query->whereHas('getClient', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%$keyword%");
                });
            })
            ->filterColumn('type', function ($query, $keyword) {
                $query->whereHas('getType', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%$keyword%");
                });
            })
            ->filterColumn('state', function ($query, $keyword) {
                $query->whereHas('getState', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%$keyword%");
                });
            })
            ;
            //->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Invoice $model
     * @return QueryBuilder
     */
    public function query(Invoice $model): QueryBuilder
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
                    ->setTableId('invoice-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
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
            //Column::make('id'),
            Column::make( __('app.invoice')),
            Column::make( __('app.date')),
            //Column::make( __('app.customer_single')),
            Column::make( __('app.type'),'type'),
            Column::make( __('app.state'), 'state'),
            Column::make( __('app.money_type'))->searchable(false),
            Column::make( __('app.total')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false),
            //->width(60)
            //->addClass('text-center'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Invoice_' . date('YmdHis');
    }
}
