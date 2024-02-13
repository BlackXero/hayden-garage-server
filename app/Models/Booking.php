<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';
    protected $fillable = array(
        'customer_id',
        'make_id',
        'model_id',
        'slot_id',
    );

    protected $with = array('vehicle','model');

    public function slot(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Slots::class,'id','slot_id');
    }

    public function vehicle(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(VehicleMake::class,'id','make_id');
    }

    public function model(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(VehicleModel::class,'id','model_id');
    }
}
