<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); 

        if ($user->role === 'admin' || $user->role === 'owner') {
            $transaksis = Transaksi::with('details.paket')->get();
        }
        elseif ($user->role === 'kasir') {
            $transaksis = Transaksi::where('id_outlet', $user->id_outlet)
                ->with('details.paket')
                ->get();
        } else {
            $transaksis = collect();
        }

        $totalPendapatan = $transaksis->sum(function ($transaksi) {
            $subtotal = $transaksi->details->sum(fn($d) => $d->paket->harga * $d->qty);
            $diskon = $subtotal * ($transaksi->diskon / 100);
            $total_sementara = $subtotal - $diskon;
            return $total_sementara + $transaksi->pajak + $transaksi->biaya_tambahan;
        });

        $members = Member::latest()->take(5)->get();

        return view('dashboard', compact('transaksis', 'totalPendapatan', 'members'));
    }
}
