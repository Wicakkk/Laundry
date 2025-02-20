<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $totalSemua = 0;
    private $data = [];

    
    public function collection()
    {
        $transaksis = Transaksi::with(['member', 'outlet', 'details.paket'])->get();
        $no = 1;

        foreach ($transaksis as $transaksi) {
            $subtotal = $transaksi->details->sum(fn($d) => $d->paket->harga * $d->qty);
            $diskon = $subtotal * ($transaksi->diskon / 100);
            $total = $subtotal - $diskon + $transaksi->pajak + $transaksi->biaya_tambahan;
            $this->totalSemua += $total;

            $this->data[] = [
                'no' => $no++,
                'invoice' => $transaksi->kode_invoice,
                'customer' => $transaksi->member->nama,
                'outlet' => $transaksi->outlet->nama,
                'deadline' => \Carbon\Carbon::parse($transaksi->batas_waktu)->format('d-m-Y'),
                'total_payment' => $total
            ];
        }

        $this->data[] = [
            'no' => '',
            'invoice' => '',
            'customer' => '',
            'outlet' => '',
            'deadline' => 'GRAND TOTAL',
            'total_payment' => $this->totalSemua
        ];

        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Invoice',
            'Customer',
            'Outlet',
            'Deadline',
            'Total Payment'
        ];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi['no'],
            $transaksi['invoice'],
            $transaksi['customer'],
            $transaksi['outlet'],
            $transaksi['deadline'],
            'Rp ' . number_format($transaksi['total_payment'], 0, ',', '.')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->data) + 1;

        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'FFDAB9'],
            ],
        ]);

        $sheet->getStyle('A1:F' . $rowCount)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $sheet->getStyle('A1:F' . $rowCount)->applyFromArray([
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        $sheet->getStyle('E' . $rowCount . ':F' . $rowCount)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
        ]);
    }
}
