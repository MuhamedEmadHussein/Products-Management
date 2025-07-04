<?php

namespace Modules\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Products\Database\Factories\CategoryFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     */
    public $translatedAttributes = ['name', 'notes'];
    protected $fillable = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}
