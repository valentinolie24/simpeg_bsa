<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rewardpunishment extends Model
{
    use HasFactory;
    protected $fillable = ['pegawai_id', 'jenis', 'tanggal', 'foto', 'catatan'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
