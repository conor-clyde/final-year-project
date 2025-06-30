<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Patron extends Model
{
    use HasFactory;

    protected $fillable = [
        'forename',
        'surname',
        'email',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
