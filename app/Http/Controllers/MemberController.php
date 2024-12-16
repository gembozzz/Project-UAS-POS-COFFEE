<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();

        return view('admin.member', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_member' => 'required|max:255',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_telp' => 'required|digits_between:10,13',
            'diskon' => 'required',
        ]);

         Member::create([
            'kode_member' => $request->kode_member,
            'nama' => $request->nama, 
            'alamat' => $request->alamat,   
            'no_telp' => $request->no_telp,
            'diskon' => $request->diskon,
        ]);

        return redirect()->route('member.index')->with('added_success', 'Member baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'kode_member' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_telp' => 'required|digits_between:10,13',
            'diskon' => 'required',
        ]);

        $member->update([
            'kode_member' => $request->kode_member,
            'nama' => $request->nama, 
            'alamat' => $request->alamat,   
            'no_telp' => $request->no_telp,
            'diskon' => $request->diskon,
        ]);

        return redirect()->route('member.index')->with('added_success', 'Member baru berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        try {
            $member->delete();
            return redirect()->route('member.index')->with('success', 'Member berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('member.index')->with('error', 'Terjadi kesalahan saat menghapus Member.');
        }
    }
}
