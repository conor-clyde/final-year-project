<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CatalogueEntry extends Model
{
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_catalogue_entries');
    }

    public function bookCopies()
    {
        return $this->hasMany(BookCopy::class);
    }
}
