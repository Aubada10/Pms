<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Shops extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'office_id',
        'size',
        'location',
        'price',
        'photo',
        'property',
        'renting_period',
        'rating',
        'contact_information'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
