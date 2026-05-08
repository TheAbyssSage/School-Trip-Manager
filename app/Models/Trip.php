<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'name',
        'destination',
        'date',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'price' => 'decimal:2',
        ];
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_trip')
            ->withPivot(['permission_given', 'paid', 'notes'])
            ->withTimestamps();
    }
}
