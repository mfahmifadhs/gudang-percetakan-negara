<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderExitItemModel extends Model
{
    use HasFactory;
    protected $table = "tbl_items_exit";
    protected $primary_key = "id_item_exit";
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'item_incoming_id',
        'ex_item_qty',
        'ex_item_description'
    ];
}
