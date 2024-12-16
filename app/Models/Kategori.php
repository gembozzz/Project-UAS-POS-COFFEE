<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori'];

    public function produk() 
    {
        return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    }
}
