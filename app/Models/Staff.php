<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Model
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
