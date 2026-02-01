<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'nik',
        'birthdate',
        'phone_number',
        'gender',
        'address',
        'note',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
