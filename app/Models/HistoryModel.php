<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryModel extends Model
{
    use HasFactory;
    protected $table        = "tbl_historys";
    protected $primaryKey   = "id_history";
    public $timestamps = false;

    protected $fillable = [
        'hist_date',
        'order_id',
        'item_id',
        'slot_id',
        'hist_total_item'
    ];
}
