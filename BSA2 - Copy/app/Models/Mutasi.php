<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;
    protected $fillable = ['pegawai_id', 'cabang_lama', 'cabang_baru', 'tanggal_mutasi', 'status_mutasi', 'catatan'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
