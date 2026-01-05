<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'nama_ruangan', // Contoh: "Poli Umum"
        'doctor_id',    // FK: Dokter yang jaga
        'status',       // Enum: tersedia, konsultasi, istirahat
    ];

    // Relasi ke Dokter
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Relasi: Satu ruangan punya banyak antrian hari ini
    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
