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
    // public function scopeWithFilters($query, $prices, $categories, $manufacturers)
    // {
    //     return $query->when(count($manufacturers), function ($query) use ($manufacturers) {
    //             $query->whereIn('manufacturer_id', $manufacturers);
    //         })
    //         ->when(count($categories), function ($query) use ($categories) {
    //             $query->whereIn('category_id', $categories);
    //         })
    //         ->when(count($prices), function ($query) use ($prices){
    //             $query->where(function ($query) use ($prices) {
    //                 $query->when(in_array(0, $prices), function ($query) {
    //                         $query->orWhere('price', '<', '5000');
    //                     })
    //                     ->when(in_array(1, $prices), function ($query) {
    //                         $query->orWhereBetween('price', ['5000', '10000']);
    //                     })
    //                     ->when(in_array(2, $prices), function ($query) {
    //                         $query->orWhereBetween('price', ['10000', '50000']);
    //                     })
    //                     ->when(in_array(3, $prices), function ($query) {
    //                         $query->orWhere('price', '>', '50000');
    //                     });
    //             });
    //         });
    // }
}
