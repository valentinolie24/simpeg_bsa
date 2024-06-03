<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumumanAkhir extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status_akhir',
        'catatan',
        'tanggal_masuk',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
