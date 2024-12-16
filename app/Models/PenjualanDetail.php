<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_penjualans';
    protected $primaryKey = 'id_detail_penjualan';
    protected $fillable = ['id_penjualan', 'id_produk', 'total_harga', 'jumlah', 'diskon', 'subtotal'];

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
}
