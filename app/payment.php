<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\sale;
use App\vehicle;
use App\User;

class payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['sale_id','vehicle_id'];

    public function sale()
    {
        return $this->belongsTo(sale::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
