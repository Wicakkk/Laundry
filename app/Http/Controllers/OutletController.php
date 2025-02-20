<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::all();
        return view('konten.outlet.outlet', compact('outlets'));
    }

    public function create()
    {
        return view('konten.outlet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:tb_outlet,nama',
            'alamat' => 'required',
            'tlp' => 'required|string|max:15',
        ]);

        Outlet::create($request->all());
        return redirect()->route('outlet.index')->with('success', 'Outlet berhasil ditambahkan!');
    }

    public function edit(Outlet $outlet)
    {
        return response()->json($outlet);
    }

    public function update(Request $request, Outlet $outlet)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required',
            'tlp' => 'required|string|max:15',
        ]);

        $outlet->update($request->all());
        return redirect()->route('outlet.index')->with('success', 'Outlet berhasil diperbarui!');
    }

    public function destroy(Outlet $outlet)
    {
        $outlet->delete();
        return redirect()->route('outlet.index')->with('success', 'Outlet berhasil dihapus!');
    }
}
