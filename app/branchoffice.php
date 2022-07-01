<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\employee;
use App\vehicle;
use App\sale;
use App\city;
use App\client;

class branchoffice extends Model
{
    protected $table = 'branchoffices';
    protected $fillable = ['state','id', 'name', 'address', 'city_id', 'employee_id'];

    public function clients()
    {
        return $this->hasMany(client::class);
    }

    public function employees()
    {
        return $this->hasMany(employee::class);
    }

    public function employee()
    {
        return $this->belongsTo(employee::class);
    }

    public function city()
    {
        return $this->belongsTo(city::class);
    }

    public function vehicles()
    {
        return $this->hasMany(vehicle::class);
    }

    public function sales()
    {
        return $this->hasMany(sale::class);
    }

}
