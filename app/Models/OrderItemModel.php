<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemModel extends Model
{
    use HasFactory;
    protected $table = "tbl_items_incoming";
    protected $primary_key = "id_item_incoming";
    public $timestamps = false;

    protected $fillable = [
        'order_data_id',
        'in_item_code',
        'in_item_nup',
        'in_item_name',
        'in_item_merk',
        'in_item_qty',
        'in_item_unit',
        'in_item_purchase',
        'in_item_condition',
        'in_item_description'
    ];
}
