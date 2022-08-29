<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotModel extends Model
{
    use HasFactory;
    protected $table = "tbl_slots";
    protected $primaryKey = "id_slot";
    public $timestamps = false;

    protected $fillable = [
        'id_slot',
        'warehouse_id',
        'slot_status'
    ];
}
