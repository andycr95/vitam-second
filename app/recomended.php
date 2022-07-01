<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\client;

class recomended extends Model
{
    protected $table = 'recomendeds';
    protected $fillable = ['client_id', 'address', 'name', 'phone'];

    public function client()
    {
        return $this->belongsTo(client::class);
    }
}
