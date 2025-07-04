<?php

namespace Modules\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Products\Database\Factories\ProductTranslationFactory;

class ProductTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'product_translations';
    public $timestamps = true;
    protected $fillable = ['name', 'description', 'notes'];

    protected static function newFactory()
    {
        return ProductTranslationFactory::new();
    }
}
