<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('konten.member.member', compact('members'));
    }

    public function create()
    {
        return view('konten.member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tlp' => 'required|string|max:15',
        ]);

        Member::create($request->all());
        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan!');
    }

    public function edit(Member $member)
    {
        return response()->json($member);
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tlp' => 'required|string|max:15',
        ]);

        $member->update($request->all());
        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus!');
    }
}
