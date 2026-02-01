<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'nik',
        'sip_number',
        'birthdate',
        'phone_number',
        'gender',
        'address',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
