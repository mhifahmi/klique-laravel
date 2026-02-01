<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = [
        'queue_number',
        'patient_id',
        'room_id',
        'status',
        'date',
        'call_at',
        'finish_at',
        'note'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_panggil' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

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
