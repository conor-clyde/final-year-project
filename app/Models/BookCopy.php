<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class BookCopy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'catalogue_entry_id',
        'publisher_id',
        'condition_id',
        'language_id',
        'format_id',
        'publish_date',
        'pages',
        'archived',
    ];

    protected $casts = [
        'publish_date' => 'datetime',
        'archived' => 'boolean',
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
        return $this->loans()->where('is_returned', false)->exists();
    }
}
