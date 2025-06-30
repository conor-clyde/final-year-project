<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patron extends Model
{
    protected $fillable = [
        'surname',
        'forename',
        'email'
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
