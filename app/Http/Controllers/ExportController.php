<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;

class ExportController extends Controller
{
    public function exportPDF()
    {
        $transaksis = Transaksi::with(['member', 'outlet', 'details.paket'])->get();

        $pdf = PDF::loadView('exports.transaksi_pdf', compact('transaksis'))->setPaper('a4', 'landscape');
        return $pdf->download('transactions.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new TransaksiExport, 'transactions.xlsx');
    }
}
