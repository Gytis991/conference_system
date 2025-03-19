<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'organizer',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'registrations')
            ->withPivot('status')
            ->withTimestamps();
    }
}
