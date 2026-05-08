<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'class',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'student_trip')
            ->withPivot(['permission_given', 'paid', 'notes'])
            ->withTimestamps();
    }
}
