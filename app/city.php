<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\branchoffice;

class city extends Model
{
    protected $table = 'cities';
    protected $fillable = ['name'];

    public function branchoffices()
    {
        return $this->hasMany(branchoffice::class);
    }
}
