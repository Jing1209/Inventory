<?php

namespace App\Models;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['category','quantity'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $query->quantity= 0;
        });

        // self::creating(function ($model) {
        //     $model->uuid = IdGenerator::generate(['table' => 'categories', 'length' => 10, 'prefix' =>'Cate-']);
        // });
    }
    
}
