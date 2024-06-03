<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tes extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'jenis_tes', 'nilai_tes', 'status_tes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function daftar()
    {
        return $this->belongsTo(Daftar::class);
    }
}
