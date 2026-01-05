<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Membolehkan input semua kolom selain ID

    protected $fillable = [
        'nama_lengkap',
        'no_telepon',
        'alamat',
        'catatan', // Opsional: Riwayat penyakit/keluhan
    ];

    // Relasi: Satu pasien bisa punya banyak riwayat antrian
    public function queues() {
        return $this->hasMany(Queue::class);
    }
}
