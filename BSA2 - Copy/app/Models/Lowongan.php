<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;
    protected $fillable = ['posisi', 'deskripsi', 'foto', 'gaji'];


    public function daftar()
    {
        return $this->hasMany(Daftar::class);
    }
}
