<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Author extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'forename',
        'surname',
        'archived'
    ];

    public function catalogueEntries()
    {
        return $this->belongsToMany(CatalogueEntry::class, 'author_catalogue_entries');
    }

    public function popularity()
    {
        return $this->catalogueEntries()
            ->with('bookCopies')
            ->count();

       // return $this->catalogueEntries()->bookCopies()->whereNull('deleted_at')->where('archived', '=', 0)->count();
    }
}
