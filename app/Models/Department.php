<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = "departments";

    protected $fillable = ['department'];

    public function building(){
        return $this->hasMany(Building::class);
    }
    public function rooms(){
        return $this->hasMany(Room::class);
    }
    public function transactions(){
        return $this->hasOne(Transaction::class);
    }
}

