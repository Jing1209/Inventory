<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = "items";

    protected $fillable = ['category_id','title','price','status','description','sponsored','item_id'];

    public function categories(){
        return $this->belongsTo(Category::class);
    }

    public function transactions(){
        return $this->hasOne(Transaction::class);
    }
    public function statuses(){
        return $this->hasMany(Status::class);
    }
    public function sponsors(){
        return $this->hasMany(Sponsor::class);
    }
    public function image(){
        return $this->hasMany(ImageItem::class);
    }
    // protected static function boot()
    // {
    //     parent::boot();

    //     // auto-sets values on creation
    //     static::creating(function ($query) {
    //         $query->item_id= NULL;
    //     });

    //     // self::creating(function ($model) {
    //     //     $model->uuid = IdGenerator::generate(['table' => 'categories', 'length' => 10, 'prefix' =>'Cate-']);
    //     // });
    // }

}
