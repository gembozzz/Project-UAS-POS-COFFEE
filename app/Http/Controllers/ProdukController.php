<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('kategori')->get();

        $kategoris = Kategori::all();
        return view('admin.produk', compact('produks', 'kategoris'));
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
            'nama_produk' => 'required|string|unique:produks,nama_produk|max:255',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'kode_produk' => 'required|string|unique:produks',
            'harga_modal' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,  
            'kode_produk' => $request->kode_produk,  
            'harga_modal' => $request->harga_modal,
            'diskon' => $request->diskon,
            'harga_jual' => $request->harga_jual,
        ]);

        return redirect()->route('produk.index')->with('added_success', 'Produk baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        // dd($produk->id_produk);
        $request->validate([
            'nama_produk' => 'required|string|unique:produks,nama_produk,' . $produk->id_produk . ',id_produk|max:255',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'kode_produk' => 'required|string|unique:produks,kode_produk,' . $produk->id_produk . ',id_produk|max:255',
            'harga_modal' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        // Update produk
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'kode_produk' => $request->kode_produk,
            'harga_modal' => $request->harga_modal,
            'diskon' => $request->diskon,
            'harga_jual' => $request->harga_jual,
        ]);

        return redirect()->route('produk.index')->with('added_success', 'Produk berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        try {
            $produk->delete();
            return redirect()->route('produk.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('produk.index')->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }
}
