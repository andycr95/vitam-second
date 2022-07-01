<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\vehicle;

class investor extends Model
{
    protected $table = 'investors';
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicles()
    {
        return $this->hasMany(vehicle::class);
    }

    public function titular()
    {
        return $this->hasOne(investor::class);
    }
}
