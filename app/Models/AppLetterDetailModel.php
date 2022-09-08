<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLetterDetailModel extends Model
{
    use HasFactory;
    protected $table        = "tbl_appletters_detail";
    protected $primaryKey   = "id_appletter_detail";
    public $timestamps      = false;

    protected $fillable = [
        'id_appletter_detail',
        'appletter_id',
        'item_category_id',
        'appletter_item_code',
        'appletter_item_nup',
        'appletter_item_name',
        'appletter_item_description',
        'appletter_item_qty',
        'appletter_item_unit',
        'item_condition_id',
        'appletter_item_status'
    ];
}
