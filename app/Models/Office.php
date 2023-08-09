<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Apartment;
use App\Models\Shop;
use App\Models\ApartmentDraft;
use App\Models\ShopDraft;
use App\Models\Land;

class Office extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'user_id',
        'logo',
        'name',
        'address',
        'phone_number',
        'rating'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function apartments(){
        return $this->hasMany(Apartments::class,'office_id');
    }

    public function shops(){
        return $this->hasMany(Shops::class,'office_id');
    }

    public function lands(){
        return $this->hasMany(Land::class,'office_id');
    }

    public function apartmentsDraft(){
        return $this->hasMany(ApartmentDraft::class,'office_id');
    }

    public function shopsDraft(){
        return $this->hasMany(ShopDraft::class,'office_id');
    }
}
