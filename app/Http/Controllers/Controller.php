<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function Item($id)
    {
        $item = ItemModel::where('id_item', $id)
                ->join('tbl_orders', 'id_order', 'order_id')
                ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->first();

        return view('barcode_item', compact('item'));
    }
}
