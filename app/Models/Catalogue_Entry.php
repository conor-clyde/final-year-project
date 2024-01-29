<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Catalogue_Entry extends Model
{
    protected $table = 'catalogue_entry';

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }


}
