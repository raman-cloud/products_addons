<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'have_addon',
    ];


    public function addons() {
        return $this->hasMany(AddonMenu::class);
    }

}
