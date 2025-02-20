<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use App\Models\Paket;

class PaketController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin' || $user->role === 'owner') {
            $pakets = Paket::with('outlet')->get();
        } else {
            $pakets = Paket::where('id_outlet', $user->id_outlet)->with('outlet')->get();
        }

        return view('konten.paket.paket', compact('pakets'));
    }

    public function create()
    {
        $outlets = Outlet::all();
        return view('konten.paket.create', compact('outlets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_outlet' => 'required',
            'jenis' => 'required',
            'nama_paket' => 'required',
            'harga' => 'required|numeric',
        ]);

        Paket::create($request->all());
        return redirect()->route('paket.index')->with('success', 'Paket berhasil ditambahkan!');
    }

    public function edit(Paket $paket)
    {
        return response()->json($paket);
    }

    public function update(Request $request, Paket $paket)
    {
        $request->validate([
            'id_outlet' => 'required',
            'jenis' => 'required',
            'nama_paket' => 'required',
            'harga' => 'required|numeric',
        ]);

        $paket->update($request->all());
        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui!');
    }

    public function destroy(Paket $paket)
    {
        $paket->delete();
        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus!');
    }
}
