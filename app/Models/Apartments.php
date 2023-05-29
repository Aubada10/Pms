<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Apartments extends Model
{
    use HasFactory;

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
        'floore',
        'property',
        'renting_period',
        'type',
        'rating',
        'contact_information'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
