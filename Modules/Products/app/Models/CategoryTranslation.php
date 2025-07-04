<?php

namespace Modules\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Products\Database\Factories\CategoryTranslationFactory;

class CategoryTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'notes'];
    protected $table = 'category_translations';
    public $timestamps = true;

    // protected static function newFactory(): CategoryTranslationFactory
    // {
    //     // return CategoryTranslationFactory::new();
    // }
}
