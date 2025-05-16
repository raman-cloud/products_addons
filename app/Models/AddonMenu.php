<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddonMenu extends Model
{
    public const CREATED_AT = 'created_date';
    public const UPDATED_AT = 'modified_date';
    
    protected $fillable = [
        'product_id',
        'title',
        'price',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

}
