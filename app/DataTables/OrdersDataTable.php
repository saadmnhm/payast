<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('order_number', function (Order $order) {
                return view('admin.apps.orders.columns._order', compact('order'));
            })
            ->editColumn('customer', function (Order $order) {
                return view('admin.apps.orders.columns._customer', compact('order'));
            })
            ->editColumn('total', function (Order $order) {
                return '<span class="fw-bold text-dark">' . $order->formatted_total . '</span>';
            })
            ->editColumn('status', function (Order $order) {
                return view('admin.apps.orders.columns._status', compact('order'));
            })
            ->editColumn('payment_method', function (Order $order) {
                $methods = [
                    'cash' => 'Espèces',
                    'card' => 'Carte',
                    'transfer' => 'Virement'
                ];
                return $methods[$order->payment_method] ?? $order->payment_method;
            })
            ->editColumn('created_at', function (Order $order) {
                return $order->created_at->format('d/m/Y H:i');
            })
            ->addColumn('action', function (Order $order) {
                return view('admin.apps.orders.columns._actions', compact('order'));
            })
            ->rawColumns(['total'])
            ->setRowId('id');
    }

    public function query(Order $model): QueryBuilder
    {
        return $model->newQuery()->with(['items'])->latest();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('orders-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>")
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0, 'desc')
            ->drawCallback("function() {" . file_get_contents(resource_path('views/admin/apps/orders/columns/_draw-scripts.js')) . "}");
    }

    public function getColumns(): array
    {
        return [
            Column::make('order_number')->title('N° Commande')->orderable(true),
            Column::make('customer')->title('Client')->searchable(false)->orderable(false),
            Column::make('total')->title('Total')->orderable(true),
            Column::make('payment_method')->title('Paiement')->orderable(true),
            Column::make('status')->title('Statut')->orderable(true),
            Column::make('created_at')->title('Date')->orderable(true),
            Column::computed('action')
                ->addClass('text-end')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    protected function filename(): string
    {
        return 'Orders_' . date('YmdHis');
    }
}