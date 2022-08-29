<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrentItemModel extends Model
{
    use HasFactory;
    protected $table        = "tbl_warrents_items";
    protected $primaryKey  = "id_warrent_item";
    public $timestamps      = false;

    protected $fillable = [
        'id_warrent_item',
        'warrent_entry_id',
        'warrent_exit_id',
        'warr_item_category',
        'warr_item_code',
        'warr_item_nup',
        'warr_item_name',
        'warr_item_type',
        'warr_item_qty',
        'warr_item_unit'
    ];
}
