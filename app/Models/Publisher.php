<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Publisher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];


    public function bookCopies()
    {
        return $this->hasMany(BookCopy::class);
    }

    public function popularity()
    {
        return $this->bookCopies()->count();
    }
}
