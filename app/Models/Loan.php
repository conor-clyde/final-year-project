<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'book_copy_id',
        'patron_id',
        'staff_id',
        'loan_date',
        'due_date',
        'return_date'
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
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
