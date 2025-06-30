<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Format extends Model
{
    protected $fillable = [
        'name',
    ];

    public function bookCopies()
    {
        return $this->hasMany(BookCopy::class);
    }
}
