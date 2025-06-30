<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Publisher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'archived',
    ];

    protected $casts = [
        'archived' => 'boolean',
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
