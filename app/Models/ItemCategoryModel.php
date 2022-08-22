<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategoryModel extends Model
{
    use HasFactory;
    protected $table = "tbl_items_category";
    protected $primary_key = "id_item_category";
    public $timestamps = false;

    protected $fillable = [
        'item_category_name',
        'item_category_description'
    ];
}
