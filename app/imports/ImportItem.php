<?php

namespace App\Imports;

use App\Models\WorkingAreaModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DB;


class ImportItem implements ToModel, WithStartRow
{

    public function  __construct($id_warrent, $workunit_id)
    {
        $this->id_warrent= $id_warrent;
        $this->workunit_id= $workunit_id;
    }

    public function model(array $row)
    {

        dd($this->workunit_id);
        foreach ($row as $data){
            $data = DB::table('tbl_warrents_item')->where('id_working_area', $row[0])->first();
            if ($data == '') {
                WorkingAreaModel::create ([
                    'id_working_area'       => random_int(100000, 999999),
                    'working_area_name'     => $row[1],
                    'working_area_category' => $row[2],
                ]);
            }
        }
    }


    public function startRow(): int
    {
        return 2;
    }
}
