<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demosi extends Model
{
    use HasFactory;
    protected $fillable = ['pegawai_id', 'jabatan_lama', 'jabatan_baru', 'tanggal_demosi', 'status_', 'catatan'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
