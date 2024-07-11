<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='products'; // Specifies the database table associated with this model. By default, Laravel assumes the table name is the plural form of the model name. This line explicitly sets it to products.
    protected $fillable=[
        'category_id',
        'meta_title',
        'meta_keyword',
        'meta_description',

        'slug',
        'name',
        'description',
        'brand',

        'selling_price',
        'original_price',
        'qty',
        'image',
        'featured',
        'popular',
        'status',

    ];

    // Relationship Method: Defines a one-to-many relationship between Product and Category.

    protected $with=['category'];//This line specifies that the category relationship should be automatically loaded with the Product model. Eager loading helps in reducing the number of queries to the database.

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');// Indicates that each product belongs to a single category.one to many means Multiple products belong to one category.
    }
}
