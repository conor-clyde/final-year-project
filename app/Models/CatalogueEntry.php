<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CatalogueEntry extends Model
{
    protected $dates = [
        'publish_date'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_catalogue_entries');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($catalogueEntry) {
            $catalogueEntry->authors()->detach();
        });
    }

    public function bookCopies()
    {
        return $this->hasMany(BookCopy::class);
    }

    public function popularity()
    {
        return $this->bookCopies()->count();
    }
}
