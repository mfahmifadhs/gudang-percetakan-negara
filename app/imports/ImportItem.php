<?php

namespace App\Imports;

use App\Models\WarrentItemModel;
use App\Models\WarrentModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DB;


class ImportItem implements ToModel, WithStartRow
{

     /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct($id_appletter)
    {
        $this->id_appletter   = $id_appletter;
    }

    public function model(array $row)
    {
        if($row[3] != null)
        {
            $data = DB::table('tbl_warrents_items')->where('warr_item_code', $row[1])->where('warr_item_code', '!=', null)->first();
            if($data == '') {
                WarrentItemModel::create ([
                    'id_warrent_item'      => Str::random(5),
                    'appletter_entry_id'   => $this->id_appletter,
                    'warr_item_category'   => $row[0],
                    'warr_item_code'       => $row[1],
                    'warr_item_nup'        => $row[2],
                    'warr_item_name'       => $row[3],
                    'warr_item_type'       => $row[4],
                    'warr_item_qty'        => $row[5],
                    'warr_item_unit'       => $row[6],
                    'warr_item_status'     => 'diterima',
                ]);
            }
        }
    }

    public function startRow(): int
    {
        return 3;
    }
}
