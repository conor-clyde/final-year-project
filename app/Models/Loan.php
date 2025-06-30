<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'book_copy_id',
        'patron_id',
        'staff_id',
        'start_time',
        'end_time',
        'is_returned',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_returned' => 'boolean',
    ];

    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class);
    }

    public function patron()
    {
        return $this->belongsTo(Patron::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
