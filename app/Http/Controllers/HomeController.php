<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexAdmin()
    {
        $kategoris = Kategori::count();
        $produks = Produk::count();
        $members = Member::count();
        $users = User::count();
        return view('admin.dashboard', compact('kategoris', 'produks', 'members', 'users'));
    }

    public function indexKasir()
    {
        $produks = Produk::count();
        $penjualans = Penjualan::count();
        return view('kasir.dashboard', compact('penjualans', 'produks'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
