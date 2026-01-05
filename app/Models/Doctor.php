<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $guarded = ['id'];

    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nomor_sip', // Surat Izin Praktik
    ];

    // Relasi: Dokter menjaga ruangan
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
