<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDataModel;

class ItemModel extends Model
{
    use HasFactory;
    protected $table      = "tbl_items";
    protected $primaryKey = "id_item";
    public $timestamps    = false;

    protected $fillable = [
        'order_id',
        'item_code',
        'item_nup',
        'item_name',
        'item_description',
        'item_qty',
        'item_unit',
        'item_purchase',
        'item_condition_id',
        'item_img',
        'item_status'
    ];
}
