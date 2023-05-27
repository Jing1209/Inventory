<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'firstname',
        'lastname',
        'gender',
        'email',
        'phone_number',
    ];
    public function transactions(){
        return $this->hasOne(Transaction::class);
    }
    public function image(){
        return $this->hasMany(EmployeeImage::class);
    }
}
