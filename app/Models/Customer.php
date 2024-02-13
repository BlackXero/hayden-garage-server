<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    protected $fillable = array(
        'first_name',
        'last_name',
        'phone',
        'email'
    );

    protected $appends = array(
        'full_name'
    );

    public function getFullNameAttribute(): string
    {
        return ucfirst($this->attributes['first_name'].' '.$this->attributes['last_name']);
    }
}
