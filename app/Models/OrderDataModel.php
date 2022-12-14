<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDataModel extends Model
{
    use HasFactory;
    protected $table = "tbl_orders_data";
    protected $primaryKey = "id_order_data";
    public $timestamps = false;

    protected $fillable = [
        'id_order_data',
        'item_id',
        'slot_id',
        'deadline',
        'total_item'
    ];
}
