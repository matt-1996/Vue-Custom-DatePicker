<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_in',
        'check_out',
        'date',
        'is_reserved',
        'is_open',
        'has_discount',
        'price',
        'room_id'
    ];

    public function room(): BelongsTo{
        return $this->belongsTo(Room::class);
    }
}
