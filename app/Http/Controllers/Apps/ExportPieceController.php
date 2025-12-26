<?php

namespace App\Http\Controllers\Apps;

use App\Exports\PiecesExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportPieceController extends Controller
{
    public function exportPiecesExcel()
    {
        return Excel::download(new PiecesExport, 'pieces.xlsx');
    }
}
