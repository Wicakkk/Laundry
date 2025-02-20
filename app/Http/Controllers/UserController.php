<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('outlet')->where('role', 'kasir')->get();
        $outlets = Outlet::all();
        return view('user', compact('users', 'outlets'));
    }

    public function store(Request $request)
    {

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'kasir',
            'id_outlet' => $request->id_outlet,
        ]);

        // User::insert($request->all());

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $outlets = Outlet::all();
        return view('user.edit', compact('user', 'outlets'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'id_outlet' => $request->id_outlet,
        ]);

        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully!');
    }
}
