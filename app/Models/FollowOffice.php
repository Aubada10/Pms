<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FollowOffice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'office_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
