<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogueEntry extends Model
{
    use SoftDeletes;

    protected $dates = [
        'publish_date'
    ];

    protected $fillable = [
        'title',
        'genre_id',
        'description',
        'language_id',
        'format_id'
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

    public function getFormattedAuthorsAttribute()
    {
        $authors = $this->authors;
        $count = $authors->count();

        if ($count === 0) {
            return 'N/A';
        }

        if ($count === 1) {
            return $authors->first()->full_name;
        }

        $names = $authors->map(function ($author) {
            return $author->full_name;
        });

        if ($count === 2) {
            return $names->implode(' & ');
        }

        $lastAuthor = $names->pop();
        return $names->implode(', ') . ' & ' . $lastAuthor;
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
