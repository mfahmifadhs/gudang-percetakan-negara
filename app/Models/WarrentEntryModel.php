<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrentEntryModel extends Model
{
    use HasFactory;
    protected $table        = "tbl_warrents_entry";
    public $timestamps      = false;

    protected $fillable = [
        'id_warrent',
        'warrent_id',
        'item_category_id',
        'warr_item_code',
        'warr_item_nup',
        'warr_item_name',
        'warr_item_description',
        'warr_item_qty',
        'warr_item_unit',
        'item_condition_id',
        'warr_item_status',
        'warr_item_note'
    ];
}
