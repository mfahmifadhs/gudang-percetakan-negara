<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLetterEntryModel extends Model
{
    use HasFactory;
    protected $table        = "tbl_appletters_entry";
    protected $primaryKey   = "id_appletter_entry";
    public $timestamps      = false;

    protected $fillable = [
        'id_appletter_entry',
        'appletter_id',
        'item_category_id',
        'appletter_item_code',
        'appletter_item_nup',
        'appletter_item_name',
        'appletter_item_merktype',
        'appletter_item_exp',
        'appletter_item_qty',
        'appletter_item_unit',
        'appletter_item_description',
        'item_condition_id',
        'appletter_item_status'
    ];
}
