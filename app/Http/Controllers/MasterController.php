<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class MasterController extends Controller
{
    public function index()
    {
        $totalDelivery  = DB::table('tbl_orders')->where('order_category','penyimpanan')->count();
        $totalPickup    = DB::table('tbl_orders')->where('order_category','pengeluaran')->count();
        $totalItemEntry = DB::table('tbl_items')->count();
        $totalItemExit  = DB::table('tbl_historys')->where('order_id','like', '%'.'PBK_'.'%')->count();
        $workunit       = DB::table('tbl_workunits')->orderBy('workunit_name', 'ASC')->get();
        $warehouse      = DB::table('tbl_warehouses')->orderBy('status_id', 'ASC')->get();
        $itemCategory   = DB::table('tbl_items_category')->get();
        $items          = DB::table('tbl_orders_data')->select('id_item','item_name','workunit_name','item_category_name','item_qty','warehouse_name')
                            ->join('tbl_slots','id_slot','slot_id')
                            ->join('tbl_warehouses','id_warehouse','warehouse_id')
                            ->join('tbl_items','id_item','item_id')
                            ->join('tbl_items_category','id_item_category','item_category_id')
                            ->join('tbl_orders','id_order','order_id')
                            ->join('tbl_workunits','id_workunit','workunit_id')
                            ->groupBy('id_item','item_name','workunit_name','item_category_name','item_qty','warehouse_name')
                            ->orderBy('item_name', 'ASC')
                            ->get();
        $chartItem      = $this->getChartItem();
        return view('v_admin_master.index', compact('totalDelivery','totalPickup','totalItemEntry','totalItemExit','workunit','items','warehouse','itemCategory','chartItem'));
    }

    public function getChartItem()
    {
        $dataBarang      = DB::table('tbl_orders_data','id_order_data','order_data_id')
            ->join('tbl_items','id_item','item_id')
            ->join('tbl_items_condition','id_item_condition','item_condition_id')
            ->join('tbl_items_category','id_item_category','item_category_id')
            ->join('tbl_slots','id_slot','slot_id')
            ->join('tbl_orders','id_order','order_id')
            ->join('tbl_workunits','id_workunit','workunit_id')
            ->get();

        $dataJenisBarang = DB::table('tbl_items_category')->get();
        foreach ($dataJenisBarang as $data) {
            $dataArray[] = $data->item_category_name;
            $dataArray[] = $dataBarang->where('item_category_name', $data->item_category_name)->count();
            $dataChart['all'][] = $dataArray;
            unset($dataArray);
        }

        $dataChart['items'] = $dataBarang;
        $chart = json_encode($dataChart);
        return $chart;
    }

    public function searchChartData(Request $request)
    {
        $dataBarang = DB::table('tbl_orders_data')->select('id_item','item_name','workunit_name','item_category_name','item_qty','warehouse_name')
                        ->join('tbl_slots','id_slot','slot_id')
                        ->join('tbl_warehouses','id_warehouse','warehouse_id')
                        ->join('tbl_items','id_item','item_id')
                        ->join('tbl_items_category','id_item_category','item_category_id')
                        ->join('tbl_orders','id_order','order_id')
                        ->join('tbl_workunits','id_workunit','workunit_id')
                        ->groupBy('id_item','item_name','workunit_name','item_category_name','item_qty','warehouse_name');

        $dataJenisBarang = DB::table('tbl_items_category')->get();
        // dd($request->all());

        if($request->hasAny(['workunit', 'item_category','warehouse'])){
            if($request->workunit){
                $dataSearch = $dataBarang->where('workunit_id', $request->workunit);
            }
            if($request->item_category){
                $dataSearch = $dataBarang->where('item_category_id', $request->item_category);
            }
            if($request->warehouse){
                $dataSearch = $dataBarang->where('warehouse_id', $request->warehouse);
            }

            $dataSearch = $dataSearch->get();

        }else {
            $dataSearch = $dataBarang->get();
        }

        // dd($dataSearch);
        foreach ($dataJenisBarang as $data) {
            $dataArray[]        = $data->item_category_name;
            $dataArray[]        = $dataSearch->where('item_category_name', $data->item_category_name)->count();
            $dataChart[]        = $dataArray;
            unset($dataArray);
        }

        $chart = json_encode($dataChart);
        $table = json_encode($dataSearch);

        if(count($dataSearch) > 0){
            return response([
                'status'    => true,
                'total'     => count($dataSearch),
                'message'   => 'success',
                'data'      => $chart,
                'dataTable' => $table
            ], 200);
        }else {
            return response([
                'status'    => true,
                'total'     => count($dataSearch),
                'message'   => 'not found'
            ], 200);
        }
    }

    // =====================================
    //               WAREHOUSE
    // =====================================

    public function showWarehouse(Request $request, $aksi, $id)
    {
        if($aksi == 'daftar'){
            //Daftar gudang
            $warehouse  = DB::table('tbl_warehouses')
                            ->join('tbl_status','tbl_status.id_status','tbl_warehouses.status_id')
                            ->orderby('status_id', 'ASC')
                            ->get();
            $model      = DB::table('tbl_warehouses')
                            ->select('warehouse_category',DB::raw('count(id_warehouse) as totalwarehouse'))
                            ->groupBy('warehouse_category')
                            ->get();
            return view('v_admin_master.show_warehouse', compact('warehouse','model'));

        }elseif($aksi == 'detail'){
            //Detail gudang
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

        }elseif($aksi == 'update'){
            //Update gudang
            WarehouseModel::where('id_warehouse', $id)
            ->update([
                        'id_warehouse'          => strtoupper($request->id_warehouse),
                        'warehouse_category'    => $request->warehouse_category,
                        'warehouse_name'        => $request->warehouse_name,
                        'warehouse_description' => $request->warehouse_description,
                        'status_id'             => $request->status_id
                    ]);
            return redirect('admin-master/gudang/daftar/semua')->with('success','Berhasil Mengubah Informasi Gudang');

        }elseif($aksi == 'slot'){
            //Slot gudang
            $slot   = DB::table('tbl_slots')
                    ->join('tbl_warehouses','tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                    ->where('id_slot', $id)
                    ->get();

            return view('v_admin_master.detail_slot', compact('slot'));

        }
    }

    // ========================================
	//     			DAFTAR BARANG
	// ========================================

    public function showItem(Request $request, $aksi, $id)
    {
        if($aksi == 'daftar'){
            $itemCategory = DB::table('tbl_items_category')->get();
            // Daftar barang masuk
            $items  = DB::table('tbl_orders_data')
                        ->join('tbl_slots','id_slot','slot_id')
                        ->join('tbl_warehouses','.id_warehouse','warehouse_id')
                        ->join('tbl_items','id_item','item_id')
                        ->join('tbl_items_category','id_item_category','item_category_id')
                        ->join('tbl_items_condition','id_item_condition','.item_condition_id')
                        ->join('tbl_orders','id_order','order_id')
                        ->join('tbl_workunits','id_workunit','workunit_id')
                        ->where('order_category','penyimpanan')
                        ->get();

            $itemExit   = DB::table('tbl_historys')
                            ->join('tbl_orders', 'id_order', 'tbl_historys.order_id')
                            ->join('tbl_items', 'id_item', 'item_id')
                            ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                            ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                            ->join('tbl_items_category','id_item_category','item_category_id')
                            ->where('order_category','pengeluaran')
                            ->get();

            return view('v_admin_master.show_item', compact('items','itemExit','itemCategory'));

        }elseif($aksi == 'slot'){
            $itemCategory = DB::table('tbl_items_category')->get();
            //Daftar barang berdasarkan slot
            $items  = DB::table('tbl_orders_data')
                                ->join('tbl_slots','id_slot','slot_id')
                                ->join('tbl_warehouses','.id_warehouse','warehouse_id')
                                ->join('tbl_items','id_item','item_id')
                                ->join('tbl_items_category','id_item_category','item_category_id')
                                ->join('tbl_items_condition','id_item_condition','.item_condition_id')
                                ->join('tbl_orders','id_order','order_id')
                                ->join('tbl_workunits','id_workunit','workunit_id')
                                ->where('slot_id', $id)
                                ->where('order_category','penyimpanan')
                                ->get();

           $itemExit     = DB::table('tbl_historys')
                                ->join('tbl_orders', 'id_order', 'tbl_historys.order_id')
                                ->join('tbl_items', 'id_item', 'item_id')
                                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                                ->join('tbl_items_category','id_item_category','item_category_id')
                                ->where('slot_id', $id)
                                ->where('order_category','pengeluaran')
                                ->get();

            return view('v_admin_master.show_item', compact('items','itemExit','itemCategory','id'));

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

        }elseif($aksi == 'tambah'){
            //Tambah unit kerja
            $workunit = new WorkunitModel();
            $workunit->workunit_name = strtolower($request->input('workunit_name'));
            $workunit->mainunit_id   = $request->input('mainunit_id');
            $workunit->save();

            return redirect('admin-master/unit-kerja/daftar/semua')->with('success','Berhasil menambah unit kerja baru');
        }

    }

    // =====================================
    //             PENGGUNA
    // =====================================

    public function showUser(Request $request, $aksi, $id)
    {
        if($aksi == 'daftar'){
            // Daftar Pengguna
            $users  = DB::table('users')
                        ->join('tbl_roles','tbl_roles.id_role','users.role_id')
                        ->join('tbl_workunits','tbl_workunits.id_workunit','users.workunit_id')
                        ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                        ->join('tbl_status','tbl_status.id_status','users.status_id')
                        ->orderBy('role_id','DESC')
                        ->get();

            return view('v_admin_master.show_user', compact('users'));

        }elseif($aksi == 'detail'){
            // Detail pengguna
            $users  = DB::table('users')
                        ->join('tbl_roles','tbl_roles.id_role','users.role_id')
                        ->join('tbl_workunits','tbl_workunits.id_workunit','users.workunit_id')
                        ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                        ->join('tbl_status','tbl_status.id_status','users.status_id')
                        ->where('id',$id)
                        ->first();
            $roles  = DB::table('tbl_roles')->where('id_role','!=',1)->get();
            $status = DB::table('tbl_status')->get();
            return view('v_admin_master.detail_user', compact('users','roles','status'));

        }elseif($aksi == 'tambah'){
            // Tambah pengguna
            $roles  = DB::table('tbl_roles')->where('id_role','!=',1)->get();
            return view('v_admin_master.create_user', compact('roles'));

        }elseif($aksi == 'proses-tambah'){
            // Proses tambah pengguna
            $users  = new User();
            $users->role_id       = $request->input('role_id');
            $users->workunit_id   = $request->input('workunit_id');
            $users->full_name     = $request->input('full_name');
            $users->nip           = $request->input('nip');
            $users->password      = Hash::make($request->input('password'));
            $users->password_text = $request->password;
            $users->status_id     = $request->input('status_id');
            $users->created_at    = Carbon::now();
            $users->save();
            return redirect('admin-master/pengguna/daftar/semua')->with('success','Berhasil menambah pengguna baru');

        }elseif($aksi == 'ubah'){
            // Ubah informasi pengguna
            User::where('id', $id)->update([
                'role_id'       => $request->role_id,
                'workunit_id'   => $request->workunit_id,
                'full_name'     => $request->full_name,
                'nip'           => $request->nip,
                'password'      => Hash::make($request->password),
                'password_text' => $request->password,
                'status_id'     => $request->status_id
            ]);
            return redirect('admin-master/pengguna/daftar/semua')->with('success','Berhasil mengubah informasi pengguna');

        }elseif($aksi == 'hapus'){
            // Hapus pengguna
            $users = User::where('id', $id);
            $users->delete();
            DB::statement("ALTER TABLE users AUTO_INCREMENT =  1");
            return redirect('admin-master/pengguna/daftar/semua')->with('success','Berhasil menghapus pengguna');
        }
    }

    // =====================================
    //             SELECT 2
    // =====================================

    public function showSelect2(Request $request, $aksi, $id)
    {
        if($aksi == 'workunit'){
            // Menampilkan unit kerja
            $search = $request->search;

            if($search == ''){
                $workunit = DB::table('tbl_workunits')->get();
            }else{
                $workunit = DB::table('tbl_workunits')->where('workunit_name', 'like', '%' .$search . '%')->get();
            }

            $response = array();
            foreach($workunit as $data){
                $response[] = array(
                    "id"    =>  $data->id_workunit,
                    "text"  =>  $data->workunit_name
                );
            }

            return response()->json($response);
        }
    }

    // =====================================
    //                JSON
    // =====================================

    public function showJson(Request $request, $aksi, $id)
    {
        if($aksi == 'mainunit'){
            // Menampilkan unit utama
            $result = DB::table('tbl_workunits')
                        ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                        ->where('id_workunit', $id)
                        ->pluck('id_mainunit','mainunit_name');
            return response()->json($result);
        }
    }

}
