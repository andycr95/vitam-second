<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\sale;
use App\recomended;
use App\purchase;
use App\payment;

class client extends Model
{
    protected $table = 'clients';
    protected $fillable = ['name', 'documento', 'address', 'phone', 'email', 'cellphone','photo','photo1','photo2','photo3'];

    public function sales()
    {
        return $this->hasMany(sale::class);
    }

    public function recomendeds()
    {
        return $this->hasOne(recomended::class);
    }

    public function branchoffice()
    {
        return $this->belongsTo(branchoffice::class);
    }

    public function payments()
    {
        return $this->hasMany(payment::class);
    }

}
