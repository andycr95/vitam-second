<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\branchoffice;
use App\vehicle;
use App\payment;
use App\client;
use App\typeSale;

class sale extends Model
{
    protected $table = 'sales';
    protected $fillable = ['client_id', 'amount', 'date', 'branchoffice_id', 'client_id', 'typesale_id', 'vehicle_id'];

    public function client()
    {
        return $this->belongsTo(client::class);
    }

    public function typesale()
    {
        return $this->belongsTo(typeSale::class);
    }

    public function branchoffice()
    {
        return $this->belongsTo(branchoffice::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(vehicle::class);
    }

    public function payments()
    {
        return $this->hasMany(payment::class);
    }
}
