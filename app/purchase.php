<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\client;
use App\vehicle;

class purchase extends Model
{
    protected $table = 'purchases';
    protected $fillable = ['date','client_id','vehicle_id'];

    public function clients()
    {
        return $this->belongsTo(client::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(vehicle::class);
    }
}
