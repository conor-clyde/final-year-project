<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Publisher extends Model
{
    public function bookCopies()
    {
        return $this->hasMany(BookCopy::class);
    }

    public function popularity()
    {
        return $this->bookCopies()->count();
    }
}
