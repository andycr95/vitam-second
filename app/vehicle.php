<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\branchoffice;
use App\type;
use App\investor;
use App\sale;
use App\payment;

class vehicle extends Model
{

    protected $table = 'vehicles';
    protected $fillable = ['placa', 'model', 'motor', 'chasis', 'color', 'branchoffice_id', 'investor_id', 'type_id'];

    public function branchoffice()
    {
        return $this->belongsTo(branchoffice::class);
    }

    public function type()
    {
        return $this->belongsTo(type::class);
    }

    public function payments()
    {
        return $this->hasMany(payment::class);
    }

    public function investor()
    {
        return $this->belongsTo(investor::class);
    }

    public function sales()
    {
        return $this->hasOne(sale::class);
    }
}
