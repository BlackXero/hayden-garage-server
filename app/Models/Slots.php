<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slots extends Model
{
    use HasFactory;

    protected $table = 'slots';

    protected $fillable = array(
        'slot_date',
        'slot_time',
        'is_booked',
        'booked_by',
        'disabled'
    );

    protected $appends = array('slot_time');

    //protected $with = array('customer');


    public function setSlotTimeAttribute($slotTime): void
    {
        $this->attributes['slot_time'] = date('H:i',strtotime($slotTime));
    }

    public function getSlotTimeAttribute(): string
    {
        return date('h:i A',strtotime($this->attributes['slot_time']));
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class,'booked_by','id');
    }

    public function booking(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Booking::class,'id','slot_id');
    }
}
