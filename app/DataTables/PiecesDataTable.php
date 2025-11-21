<?php

namespace App\DataTables;

use App\Models\Piece;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PiecesDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('name', function (Piece $piece) {
                return view('admin.apps.cataloge.pieces.columns._piece', compact('piece'));
            })
            ->editColumn('category_id', function (Piece $piece) {
                return $piece->category ? $piece->category->full_path : '-';
            })
            ->editColumn('price', function (Piece $piece) {
                return '<span class="fw-bold text-dark">' . $piece->formatted_price . '</span>';
            })
            ->editColumn('stock', function (Piece $piece) {
                $class = $piece->stock > 10 ? 'success' : ($piece->stock > 0 ? 'warning' : 'danger');
                return '<span class="badge badge-light-' . $class . '">' . $piece->stock . '</span>';
            })
            ->editColumn('is_active', function (Piece $piece) {
                return view('admin.apps.cataloge.pieces.columns._status', compact('piece'));
            })
            ->addColumn('action', function (Piece $piece) {
                return view('admin.apps.cataloge.pieces.columns._actions', compact('piece'));
            })
            ->rawColumns(['price', 'stock'])
            ->setRowId('id');
    }

    public function query(Piece $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('category')
            ->latest();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pieces-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>")
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/admin/apps/cataloge/pieces/columns/_draw-scripts.js')) . "}");
    }

    public function getColumns(): array
    {
        return [
            Column::make('name')->title('Pièce'),
            Column::make('reference')->title('Référence'),
            Column::make('category_id')->title('Catégorie'),
            Column::make('price')->title('Prix'),
            Column::make('stock')->title('Stock')->searchable(false),
            Column::make('is_active')->title('Statut'),
            Column::computed('action')
                ->addClass('text-end')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }
}