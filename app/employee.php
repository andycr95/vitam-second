<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\branchoffice;

class employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['salary','branchoffice_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branchoffice()
    {
        return $this->belongsTo(branchoffice::class);
    }

    public function branch()
    {
        return $this->hasOne(branchoffice::class);
    }

}