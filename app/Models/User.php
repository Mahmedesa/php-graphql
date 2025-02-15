<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{
    protected $table = "users";
    public $timestamps = false;
    protected $fillable = ['name', 'email', 'mobile'];

    public function address(){
        return $this->hasMany(Address::class);
    }
}