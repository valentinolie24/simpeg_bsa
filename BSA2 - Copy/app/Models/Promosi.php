<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promosi extends Model
{
    use HasFactory;
    protected $fillable = ['pegawai_id', 'jabatan_baru', 'tanggal_promosi', 'status_promosi', 'catatan'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
