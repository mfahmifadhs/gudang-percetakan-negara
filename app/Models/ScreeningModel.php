<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreeningModel extends Model
{
    use HasFactory;
    protected $table        = "tbl_items_screening";
    protected $primaryKey   = "id_item_screening";
    public $timestamps = false;

    protected $fillable = [
        'id_item_screening',
        'warrent_id',
        'order_id',
        'item_id',
        'item_received',
        'status_screening',
        'screening_notes',
        'approve_petugas',
        'approve_workunit',
        'screening_date'
    ];
}
