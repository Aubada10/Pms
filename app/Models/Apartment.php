<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'office_id',
        'photo',
        'size',
        'location',
        'price',
        'view',
        'room_number',
        'bathrooms',
        'cladding',
        'floor_number',
        'property',
        'renting_period',
        'type',
        'rating',
        'phone_number'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
