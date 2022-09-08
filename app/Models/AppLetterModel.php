<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLetterModel extends Model
{
    use HasFactory;
    protected $table        = "tbl_appletters";
    protected $primaryKey   = "id_app_letter";
    public $timestamps      = false;

    protected $fillable = [
        'id_app_letter',
        'workunit_id',
        'appletter_file',
        'appletter_purpose',
        'appletter_total_item',
        'appletter_date',
        'appletter_status',
        'appletter_note'
    ];
}
