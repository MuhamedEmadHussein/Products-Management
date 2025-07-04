<?php

namespace Modules\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Products\Database\Factories\ProductFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     */
    public $translatedAttributes = ['name', 'description', 'notes'];
    protected $fillable = ['category_id', 'price', 'stock', 'image', 'status'];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}
