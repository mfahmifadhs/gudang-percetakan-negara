<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WarehouseModel;
use App\Models\SlotModel;
use App\Models\RackModel;
use App\Models\OrderModel;
use App\Models\OrderDataModel;
use App\Models\OrderDetailModel;
use App\Models\ItemCategoryModel;
use App\Models\WorkunitModel;
use App\Models\User;

use DB;
use Auth;
use Hash;
use Str;
use PDF;
use Validator;
use Carbon\Carbon;


class MasterController extends Controller
{
    public function index()
    {
        return view('v_admin_master.index');
    }

    // =====================================
    //               WAREHOUSE
    // =====================================

    public function showWarehouse()
    {
        $warehouse  = DB::table('tbl_warehouses')
                        ->join('tbl_status','tbl_status.id_status','tbl_warehouses.status_id')
                        ->orderby('status_id', 'ASC')
                        ->get();
        $model      = DB::table('tbl_warehouses')
                        ->select('warehouse_category',DB::raw('count(id_warehouse) as totalwarehouse'))
                        ->groupBy('warehouse_category')
                        ->get();
        return view('v_admin_master.show_warehouse', compact('warehouse','model'));
    }

    public function detailWarehouse(Request $request, $id)
    {
        $warehouse      = DB::table('tbl_warehouses')
                            ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
                            ->where('id_warehouse', $id)
                            ->get();
        $warehouse09b   = DB::table('tbl_warehouses')
                            ->join('tbl_status','tbl_status.id_status','tbl_warehouses.status_id')
                            ->where('id_warehouse', 'G09B')
                            ->get();

        $warehouse05b   = DB::table('tbl_warehouses')
                            ->join('tbl_status','tbl_status.id_status','tbl_warehouses.status_id')
                            ->where('id_warehouse', 'G05B')
                            ->get();
        $pallet         = DB::table('tbl_slots_names')
                            ->join('tbl_slots','tbl_slots.id_slot','tbl_slots_names.pallet_id')
                            ->get();
        $slot           = DB::table('tbl_slots')
                            ->join('tbl_warehouses','tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                            ->where('warehouse_id', $id)
                            ->first();

        // SELECT RACK

        $rack_pallet_one_lvl1   = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'I')
                                    ->where('rack_level', 'Bawah')
                                    ->get();
        $rack_pallet_one_lvl2   = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'I')
                                    ->where('rack_level', 'Atas')
                                    ->get();
        $rack_pallet_two_lvl1   = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'II')
                                    ->where('rack_level', 'Bawah')
                                    ->get();
        $rack_pallet_two_lvl2   = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'II')
                                    ->where('rack_level', 'Atas')
                                    ->get();
        $rack_pallet_three_lvl1 = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'III')
                                    ->where('rack_level', 'Bawah')
                                    ->get();
        $rack_pallet_three_lvl2 = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'III')
                                    ->where('rack_level', 'Atas')
                                    ->get();

        $rack_pallet_four_lvl1  = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'IV')
                                    ->where('rack_level', 'Bawah')
                                    ->get();
        $rack_pallet_four_lvl2  = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'IV')
                                    ->where('rack_level', 'Atas')
                                    ->get();

        return view('v_admin_master.detail_warehouse', compact('slot','warehouse','warehouse09b','warehouse05b','pallet',
        'rack_pallet_one_lvl1','rack_pallet_one_lvl2','rack_pallet_two_lvl1','rack_pallet_two_lvl2','rack_pallet_three_lvl1',
        'rack_pallet_three_lvl2','rack_pallet_four_lvl1','rack_pallet_four_lvl2',));
    }

    public function updateWarehouse(Request $request, $id)
    {
        $ceknip = Validator::make($request->all(), [
                    'id_warehouse' => 'unique:tbl_warehouses',
                  ]);

        if ($ceknip->fails()) {
            return redirect('admin-master/show-warehouse')->with('failed', 'Kode Gudang Telah Terdaftar');
        }else{
            WarehouseModel::where('id_warehouse', $id)->update([
                                    'id_warehouse'          => strtoupper($request->id_warehouse),
                                    'warehouse_category'    => $request->warehouse_category,
                                    'warehouse_name'        => $request->warehouse_name,
                                    'warehouse_description' => $request->warehouse_description,
                                    'status_id'             => $request->status_id
                                ]);
            return redirect('admin-master/show-warehouse')->with('success','Berhasil Mengubah Informasi Gudang');
        }
    }

    public function detailSlot($id)
    {
        $slot   = DB::table('tbl_slots')
                    ->join('tbl_warehouses','tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                    ->where('id_slot', $id)
                    ->get();
        return view('v_admin_master.detail_slot', compact('slot'));
    }

    // ========================================
	//     			DAFTAR BARANG
	// ========================================

    public function showItem(Request $request, $aksi, $id)
    {
        if($aksi == 'daftar'){
            // Daftar barang masuk
            $item_incoming  = DB::table('tbl_items_incoming')
                                ->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
                                ->join('tbl_items_category','tbl_items_category.id_item_category','tbl_orders_data.itemcategory_id')
                                ->leftjoin('tbl_items_condition','tbl_items_condition.id_item_condition','tbl_items_incoming.in_item_condition')
                                ->join('tbl_orders','tbl_orders.id_order','tbl_orders_data.order_id')
                                ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
                                ->join('tbl_slots','tbl_slots.id_slot','tbl_orders_data.slot_id')
                                ->join('tbl_warehouses','.tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                                ->where('order_category','Pengiriman')
                                ->where('in_item_qty','!=', 0)
                                ->get();

           $item_pickup     = DB::table('tbl_items_exit')
                                ->join('tbl_items_incoming','tbl_items_incoming.id_item_incoming','tbl_items_exit.item_incoming_id')
                                ->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
                                ->join('tbl_items_category','tbl_items_category.id_item_category','tbl_orders_data.itemcategory_id')
                                ->leftjoin('tbl_items_condition','tbl_items_condition.id_item_condition','tbl_items_incoming.in_item_condition')
                                ->join('tbl_orders','tbl_orders.id_order','tbl_items_exit.order_id')
                                ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
                                ->join('tbl_slots','tbl_slots.id_slot','tbl_orders_data.slot_id')
                                ->join('tbl_warehouses','.tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                                ->where('order_category','Pengeluaran')
                                ->get();

            $item_category  = DB::table('tbl_items_category')->get();

            return view('v_admin_master.show_item', compact('item_incoming','item_pickup','item_category','id'));

        }elseif($aksi == 'slot'){
            //Daftar barang berdasarkan slot
            $item_incoming  = DB::table('tbl_items_incoming')
                                ->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
                                ->join('tbl_items_category','tbl_items_category.id_item_category','tbl_orders_data.itemcategory_id')
                                ->leftjoin('tbl_items_condition','tbl_items_condition.id_item_condition','tbl_items_incoming.in_item_condition')
                                ->join('tbl_orders','tbl_orders.id_order','tbl_orders_data.order_id')
                                ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
                                ->join('tbl_slots','tbl_slots.id_slot','tbl_orders_data.slot_id')
                                ->join('tbl_warehouses','.tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                                ->where('slot_id', $id)
                                ->where('in_item_qty','!=', 0)
                                ->get();

           $item_pickup     = DB::table('tbl_items_exit')
                                ->join('tbl_items_incoming','tbl_items_incoming.id_item_incoming','tbl_items_exit.item_incoming_id')
                                ->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
                                ->join('tbl_items_category','tbl_items_category.id_item_category','tbl_orders_data.itemcategory_id')
                                ->leftjoin('tbl_items_condition','tbl_items_condition.id_item_condition','tbl_items_incoming.in_item_condition')
                                ->join('tbl_orders','tbl_orders.id_order','tbl_items_exit.order_id')
                                ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
                                ->join('tbl_slots','tbl_slots.id_slot','tbl_orders_data.slot_id')
                                ->join('tbl_warehouses','.tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                                ->where('slot_id', $id)
                                ->get();

            $item_category  = DB::table('tbl_items_category')->get();

            return view('v_admin_master.show_item', compact('item_incoming','item_pickup','item_category','id'));

        }elseif($aksi == 'tambah-kategori'){
            //Tambah kategori barang
            return view('v_admin_master.create_category');

        }elseif($aksi == 'post-kategori'){
            //Post kategori barang
            $category = new ItemCategoryModel();
            $category->item_category_name        = strtolower($request->input('item_category_name'));
            $category->item_category_description = strtolower($request->input('item_category_description'));
            $category->save();

            return redirect('admin-master/barang/daftar/semua/#tabs-category')->with('success','Berhasil menambah kategori baru');

        }elseif($aksi == 'ubah-kategori'){
            //Ubah kategori barang
            $category = DB::table('tbl_items_category')->where('id_item_category', $id)->first();
            return view('v_admin_master.edit_category', compact('category'));

        }elseif($aksi == 'update-kategori'){
            //Update kategori barang
            ItemCategoryModel::where('id_item_category', $id)
            ->update([
                'item_category_name'        => $request->item_category_name,
                'item_category_description' => $request->item_category_description
            ]);

            return redirect('admin-master/barang/ubah-kategori/'. $id)->with('success','Berhasil mengubah kategori');

        }elseif($aksi == 'hapus-kategori'){
            //Hapus barang
            $category = ItemCategoryModel::where('id_item_category', $id);
            $category->delete();

            return redirect('admin-master/barang/daftar/semua/#tabs-category')->with('success','Berhasil menghapus kategori');

        }

    }

    // =====================================
    //             UNIT KERJA
    // =====================================

    public function showWorkunit(Request $request, $aksi, $id)
    {
        if($aksi == 'daftar'){
            $workunit   = DB::table('tbl_workunits')
                            ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                            ->get();
            $mainunit   = DB::table('tbl_mainunits')->get();
            return view('v_admin_master.show_workunit', compact('workunit','mainunit'));
        }

    }

}
