<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseModel extends Model
{
    use HasFactory;
    protected $table = "tbl_warehouses";
    protected $primary_key = "id_warehouse";
    public $timestamps = false;

    protected $fillable = [
        'id_warehouse',
        'warehouse_category',
        'warehouse_name',
        'warehouse_description',
        'status_id'
    ];
}
