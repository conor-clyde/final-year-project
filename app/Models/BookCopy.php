<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class BookCopy extends Model
{
    use SoftDeletes;

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function catalogueEntry()
    {
        return $this->belongsTo(CatalogueEntry::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

}
