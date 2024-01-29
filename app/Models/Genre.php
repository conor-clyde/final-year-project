<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Genre extends Model
{
    use SoftDeletes;

    protected $table = 'genre';

    public function catalogueEntries()
    {
        return $this->hasMany(Catalogue_Entry::class);
    }



    public function popularity()
    {
        return $this->catalogueEntries()->count();
    }
}
