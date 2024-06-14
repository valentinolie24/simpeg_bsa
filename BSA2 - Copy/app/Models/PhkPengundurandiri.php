<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhkPengundurandiri extends Model
{
    use HasFactory;
    protected $fillable = ['pegawai_id', 'tanggal', 'status_pekerjaan', 'foto', 'status', 'catatan'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
