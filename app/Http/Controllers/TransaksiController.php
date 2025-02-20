<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin' || $user->role === 'owner') {
            $transaksis = Transaksi::with(['outlet', 'member'])->get();
        } else {
            $transaksis = Transaksi::whereHas('outlet', function ($query) use ($user) {
                $query->where('id', $user->id_outlet);
            })->with(['outlet', 'member'])->get();
        }

        $outlets = DB::table('tb_outlet')->get();
        $members = DB::table('tb_member')->get();
        $pakets = DB::table('tb_paket')->get();

        return view('konten.transaksi.transaksi', compact('transaksis', 'outlets', 'members', 'pakets'));
    }

    public function create()
    {
        $user = Auth::user();
        $outlet = DB::table('tb_outlet')->where('id', $user->id_outlet)->first();
        $members = DB::table('tb_member')->get();
        $pakets = DB::table('tb_paket')->where('id_outlet', $user->id_outlet)->get();

        return view('konten.transaksi.create', compact('user', 'outlet', 'members', 'pakets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_member' => 'required|exists:tb_member,id',
            'batas_waktu' => 'required|date',
            'paket' => 'required|array',
            'paket.*.id_paket' => 'required|exists:tb_paket,id',
            'paket.*.qty' => 'required|numeric|min:1',
            'biaya_tambahan' => 'nullable|integer|min:0',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        $user = Auth::user();

        $subtotal = 0;
        foreach ($request->paket as $item) {
            $paket = Paket::findOrFail($item['id_paket']);
            $subtotal += $paket->harga * $item['qty'];
        }

        $pajak = $subtotal * 0.0075;

        $transaksi = Transaksi::create([
            'id_outlet' => $user->id_outlet,
            'kode_invoice' => 'INV-' . time(),
            'id_member' => $request->id_member,
            'tgl' => Carbon::now(),
            'batas_waktu' => $request->batas_waktu,
            'tgl_bayar' => null,
            'biaya_tambahan' => $request->biaya_tambahan ?? 0,
            'diskon' => $request->diskon ?? 0,
            'pajak' => $pajak,
            'status' => 'baru',
            'dibayar' => 'belum_dibayar',
            'id_user' => $user->id
        ]);

        foreach ($request->paket as $item) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_paket' => $item['id_paket'],
                'qty' => $item['qty'],
                'keterangan' => $item['keterangan'] ?? null
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaction added successfully');
    }


    public function edit($id)
    {
        $user = Auth::user();
        $transaksi = Transaksi::findOrFail($id);
        $outlet = DB::table('tb_outlet')->where('id', $user->id_outlet)->first();
        $members = DB::table('tb_member')->get();
        $pakets = DB::table('tb_paket')->where('id_outlet', $user->id_outlet)->get();

        return view('konten.transaksi.edit', compact('transaksi', 'outlet', 'members', 'pakets'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_member' => 'required|exists:tb_member,id',
            'batas_waktu' => 'required|date',
            'status' => 'required|in:baru,proses,selesai,diambil',
            'dibayar' => 'required|in:dibayar,belum_dibayar',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'id_member' => $request->id_member,
            'batas_waktu' => $request->batas_waktu,
            'status' => $request->status,
            'dibayar' => $request->dibayar,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaction updated successfully');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('details.paket')->findOrFail($id);
        return response()->json($transaksi);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaction deleted successfully.');
    }

    public function exportPDF(Request $request)
    {
        $bulan = $request->bulan;
        $query = Transaksi::query();

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        $transaksis = $query->get();

        $pdf = PDF::loadView('laporan.pdf', compact('transaksis'));
        return $pdf->download('Laporan_Transaksi_' . ($bulan ? date('F', mktime(0, 0, 0, $bulan, 1)) : 'Semua') . '.pdf');
    }
    

}
