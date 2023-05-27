<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $table = "buildings";

    protected $fillable = ['building'];

    public function rooms(){
        return $this->hasMany(Room::class);
    }
    public function transactions(){
        return $this->hasOne(Transaction::class);
    }
}
