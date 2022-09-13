<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrentExitModel extends Model
{
    use HasFactory;
    protected $table        = "tbl_warrents_exit";
    protected $primaryKey   = "id_warr_exit";
    public $timestamps      = false;

    protected $fillable = [
        'id_warr_exit',
        'warrent_id',
        'item_id',
        'warr_item_pick',
        'warr_item_status',
        'warr_item_note'
    ];
}
