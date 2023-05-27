<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeImage extends Model
{
    use HasFactory;
    protected $table = 'employeeimages';
    protected $fillable = [
        'url', 'employee_id'
        ];
    public function employee()
        {
        return $this->belongsTo(Employee::class);
        }
}
