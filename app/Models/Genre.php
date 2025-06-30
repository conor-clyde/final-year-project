<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Genre extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'archived',
    ];

    protected $casts = [
        'archived' => 'boolean',
    ];

    public function catalogueEntries()
    {
        return $this->hasMany(CatalogueEntry::class);
    }

    public function popularity()
    {
        return $this->catalogueEntries()->count();
    }
}
