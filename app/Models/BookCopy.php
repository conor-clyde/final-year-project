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

    protected $casts = [
        'publish_date' => 'datetime',
    ];

    public function catalogueEntry()
    {
        return $this->belongsTo(CatalogueEntry::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function format()
    {
        return $this->belongsTo(Format::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function popularity()
    {
        return $this->loans()->count();
    }

    public function isOnLoan()
    {
        // Check if there is an active loan for the book
        return $this->loans()->where('is_returned', 0)->exists();
    }


}
