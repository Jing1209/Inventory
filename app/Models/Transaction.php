<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";

    protected $fillable = [
        'item_id',
        'employee_id',
        'room_id',
        'condition',
        'buidling_id',
        'status'
    ];

    public function items()
    {
        return $this->belongsTo(Item::class);
    }

    public function rooms()
    {
        return $this->belongsTo(Room::class);
    }

    public function employees()
    {
        return $this->belongsTo(Employee::class);
    }
    public function conditions()
    {
        return $this->hasMany(Status::class);
    }
    public function buildings()
    {
        return $this->belongsTo(Buidling::class);
    }
}
