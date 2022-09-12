<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLetterExitModel extends Model
{
    use HasFactory;
    protected $table        = "tbl_appletters_exit";
    protected $primaryKey   = "id_appletter_exit";
    public $timestamps      = false;

    protected $fillable = [
        'id_appletter_exit',
        'appletter_id',
        'item_id',
        'item_pick',
        'appletter_status'
    ];
}
