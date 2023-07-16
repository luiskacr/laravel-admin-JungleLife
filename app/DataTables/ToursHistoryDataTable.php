<?php

namespace App\DataTables;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ToursHistoryDataTable extends DataTable
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
            ->addColumn('action', function (Tour $tour){
                return '<div class="justify-content-between">
                                <a class="m-2" href="'.route('tour-history.show',$tour->id).'"><i class="bx bxs-show me-1"></i> '.__('app.crud_show').' </a>
                            </div>';
            })
            ->addColumn( __('app.name'), function (Tour $tour){
                return $tour->title;
            })
            ->addColumn( __('app.used_space'), function(Tour $tour) {
                return $tour->usedSpace();
            })
            ->addColumn(__('app.tour_type_singular') , function(Tour $tour) {
                return $tour->tourType->name;
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Tour $model
     * @return QueryBuilder
     */
    public function query(Tour $model): QueryBuilder
    {
        return $model->newQuery()->where('state','=',2)
            ->orderBy('end', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return HtmlBuilder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('tourshistory-table')
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
            Column::make( 'id'),
            Column::make( __('app.name'), 'title'),
            Column::make(__('app.used_space'))
                ->searchable(false),
            Column::make(__('app.tour_type_singular')  ),
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
        return 'ToursHistory_' . date('YmdHis');
    }
}
