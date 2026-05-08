<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'class',
    ];

    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'student_trip')
            ->withPivot(['permission_given', 'paid', 'notes'])
            ->withTimestamps();
    }
}
