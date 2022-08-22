<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDataModel extends Model
{
    use HasFactory;
    protected $table = "tbl_orders_data";
    protected $primary_key = "id_order_data";
    public $timestamps = false;

    protected $fillable = [
        'id_order_data',
        'order_id',
        'slot_id',
        'itemcategory_id',
        'total_item',
        'deadline'
    ];
}
