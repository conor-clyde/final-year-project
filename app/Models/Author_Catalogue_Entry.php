<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Thiagoprz\EloquentCompositeKey\HasCompositePrimaryKey;

class Author_Catalogue_Entry extends Model
{

    public $timestamps = false;
    protected $table = 'author_catalogue_entry';



}
