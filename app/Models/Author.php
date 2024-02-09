<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Author extends Model
{

    // Author.php
    public function catalogueEntries()
    {
        return $this->belongsToMany(CatalogueEntry::class, 'author_catalogue_entries');
    }


}
