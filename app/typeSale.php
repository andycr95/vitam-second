<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\sale;

class typeSale extends Model
{
    protected $table = 'type_sales';
    protected $fillable = ['name', 'amount'];

    public function sale()
    {
        return $this->hasMany(sale::class);
    }
}
