<?php

namespace App\Models;

use app\Models\User;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{

    protected $fillable = ['user_id', 'category_id', 'product_name', 'description', 'original_price', 'price', 'best_defore_date', 'is_expired', 'is_sold', 'product_img_file_path', 'seller_id', 'prefecture'];

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller', 'seller_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
