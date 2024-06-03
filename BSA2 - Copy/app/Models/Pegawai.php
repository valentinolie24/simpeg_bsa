<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $fillable = ['nik', 'nama', 'alamat', 'ttl', 'jabatan', 'tanggal_masuk', 'pendidikan', 'status', 'agama', 'status_pekerjaan', 'foto'];
}
