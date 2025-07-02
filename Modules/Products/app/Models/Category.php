<?php

namespace Modules\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Products\Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'notes'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}
