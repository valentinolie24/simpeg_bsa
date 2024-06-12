<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $fillable = ['nik', 'nama', 'alamat', 'tempat_lahir','ttl', 'jabatan', 'tanggal_masuk', 'pendidikan', 'status', 'agama', 'status_pekerjaan', 'foto', 'cabang_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promosi()
    {
        return $this->hasMany(Promosi::class);
    }

    public function demosi()
    {
        return $this->hasMany(Demosi::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
