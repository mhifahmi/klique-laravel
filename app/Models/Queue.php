<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = [
        'nomor_antrian', // A-001, A-002 (Akan digenerate otomatis nanti)
        'tanggal',       // YYYY-MM-DD
        'waktu_panggil', // Timestamp saat status berubah jadi 'dipanggil'
        'waktu_selesai', // Timestamp saat status berubah jadi 'selesai'
        'status',        // menunggu, dipanggil, dilayani, selesai, terlewat
        'patient_id',    // FK Pasien
        'room_id',       // FK Ruangan
        'user_id',       // FK User (Staf yang mendaftarkan)
    ];

    // Casting agar 'tanggal' otomatis dianggap object Date oleh Laravel
    // Agar kolom tanggal otomatis jadi format Date Carbon
    protected $casts = [
        'tanggal' => 'date',
        'waktu_panggil' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    // Relasi-relasi
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
