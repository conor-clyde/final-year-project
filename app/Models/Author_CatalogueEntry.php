<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Author_CatalogueEntry extends Model
{
    protected $table = 'author_catalogue_entries';
    public $timestamps = false;
    protected $primaryKey = ['author_id', 'catalogue_entry_id'];
    public $incrementing = false;

    protected $fillable = [
        'author_id',
        'catalogue_entry_id'
    ];
}
