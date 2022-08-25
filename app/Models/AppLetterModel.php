<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLetterModel extends Model
{
    use HasFactory;
    protected $table        = "tbl_appletters";
    protected $primary_key  = "id_app_letter";
    public $timestamps      = false;

    protected $fillable = [
        'workunit_id','appletter_purpose','appletter_ctg','appletter_num',
        'appletter_regarding','appletter_text','appletter_date','appletter_status'
    ];
}
