<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;
    protected $table = "tbl_orders";
    protected $primary_key = "id_order";
    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'warrent_id',
        'adminuser_id',
        'workunit_id',
        'order_license_vehicle',
        'order_emp_name',
        'order_emp_position',
        'order_category',
        'order_tm',
        'order_dt'
    ];
}
