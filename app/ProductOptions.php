<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOptions extends Model
{
    use SoftDeletes;

    protected $table = 'products_options';

    protected $fillable = [
        'user_id',
        'product_id',
        'option_name',
        'option_value',
    ];

    public function products() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
