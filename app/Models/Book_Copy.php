<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Book_Copy extends Model
{
    protected $table = 'book_copy';

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

}
