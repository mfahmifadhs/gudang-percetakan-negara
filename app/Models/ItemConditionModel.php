<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemConditionModel extends Model
{
    use HasFactory;
    protected $table = "tbl_items_condition";
    protected $primaryKey = "id_item_condition";
    public $timestamps = false;

    protected $fillable = [
        'item_condition_name',
    ];
}
