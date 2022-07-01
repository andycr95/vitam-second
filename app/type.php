<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\vehicle;

class type extends Model
{
    protected $table = 'types';
    protected $fillable = ['name'];

    public function vehicles()
    {
        return $this->hasMany(vehicle::class);
    }
}
