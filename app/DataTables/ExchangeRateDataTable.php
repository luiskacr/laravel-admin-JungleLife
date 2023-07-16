<?php

namespace App\DataTables;

use App\Models\ExchangeRate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ExchangeRateDataTable extends DataTable
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
            ->addColumn(__('app.date'), function (ExchangeRate $exchangeRate){
                return Carbon::parse($exchangeRate->date)->format('d/m/Y');
            })
            ->addColumn( __('app.exchange_buy'), function (ExchangeRate $exchangeRate){
                return '₡'. $exchangeRate->buy ;
            })
            ->addColumn( __('app.exchange_sell'), function (ExchangeRate $exchangeRate){
                return '₡'. $exchangeRate->sell ;
            })
            ->filterColumn(__('app.date'), function ($query, $keyword) {
                $query->whereDate('date', '=', Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d'));
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param ExchangeRate $model
     * @return QueryBuilder
     */
    public function query(ExchangeRate $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('date','desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('exchangerate-table')
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
            Column::make('id'),
            Column::make(__('app.date'), 'date'),
            Column::make(__('app.exchange_buy'))->searchable(false),
            Column::make(__('app.exchange_sell'))->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'ExchangeRate_' . date('YmdHis');
    }
}
