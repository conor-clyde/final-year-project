<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name'
    ];

    public function bookCopies()
    {
        return $this->hasMany(BookCopy::class);
    }
}
