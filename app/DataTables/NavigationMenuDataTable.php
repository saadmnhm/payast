<?php

namespace App\DataTables;

use App\Models\NavigationMenu;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class NavigationMenuDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['title', 'status', 'action'])
            ->editColumn('title', function (NavigationMenu $menu) {
                return view('admin/apps.navigation-menu.columns._title', compact('menu'));
            })
            ->editColumn('url', function (NavigationMenu $menu) {
                return $menu->url ?? '<span class="text-muted">-</span>';
            })
            ->editColumn('parent', function (NavigationMenu $menu) {
                return $menu->parent ? $menu->parent->title : '<span class="badge badge-light-primary">Parent</span>';
            })
            ->editColumn('order', function (NavigationMenu $menu) {
                return sprintf('<span class="badge badge-light">%d</span>', $menu->order);
            })
            ->editColumn('status', function (NavigationMenu $menu) {
                return view('admin/apps.navigation-menu.columns._status', compact('menu'));
            })
            ->addColumn('action', function (NavigationMenu $menu) {
                return view('admin/apps.navigation-menu.columns._actions', compact('menu'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(NavigationMenu $model): QueryBuilder
    {
        return $model->with('parent')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('navigation-menu-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(4); // Order by 'order' column
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('title')->title('Titre'),
            Column::make('url')->title('URL'),
            Column::make('parent')->title('Parent')->searchable(false),
            Column::make('order')->title('Ordre')->addClass('text-center')->width(80),
            Column::make('status')->title('Statut')->addClass('text-center')->width(100),
            Column::computed('action')
                ->title('Actions')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(100)
        ];
    }
}
