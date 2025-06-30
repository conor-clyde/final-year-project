<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CatalogueEntry extends Model
{
    use HasFactory;

    protected $dates = [
        'publish_date'
    ];

    protected $fillable = [
        'title',
        'description',
        'genre_id',
        'language_id',
        'format_id',
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
        return $this->belongsToMany(Author::class, 'author_catalogue_entry');
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

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function format()
    {
        return $this->belongsTo(Format::class);
    }

    public function popularity()
    {
        return $this->bookCopies()->withCount('loans')->get()->sum('loans_count');
    }
}
