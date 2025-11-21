<?php

namespace App\DataTables;

use App\Models\CatalogCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CatalogCategoriesDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('title', function (CatalogCategory $category) {
                return view('admin.apps.cataloge.categories.columns._category', compact('category'));
            })
            ->editColumn('parent_id', function (CatalogCategory $category) {
                return $category->parent ? $category->parent->title : '<span class="badge badge-light-secondary">Catégorie principale</span>';
            })
            ->editColumn('pieces_count', function (CatalogCategory $category) {
                return '<span class="badge badge-light-primary">' . $category->pieces_count . ' pièces</span>';
            })
            ->editColumn('is_active', function (CatalogCategory $category) {
                return view('admin.apps.cataloge.categories.columns._status', compact('category'));
            })
            ->addColumn('action', function (CatalogCategory $category) {
                return view('admin.apps.cataloge.categories.columns._actions', compact('category'));
            })
            ->rawColumns(['parent_id', 'pieces_count', 'is_active'])
            ->setRowId('id');
    }

    public function query(CatalogCategory $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['parent', 'children'])
            ->withCount('pieces')
            ->orderBy('order');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('catalog-categories-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>")
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(4)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/admin/apps/cataloge/categories/columns/_draw-scripts.js')) . "}");
    }

    public function getColumns(): array
    {
        return [
            Column::make('title')->title('Catégorie'),
            Column::make('parent_id')->title('Parent'),
            Column::make('pieces_count')->title('Pièces')->searchable(false),
            Column::make('is_active')->title('Statut'),
            Column::computed('action')
                ->addClass('text-end')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }
}