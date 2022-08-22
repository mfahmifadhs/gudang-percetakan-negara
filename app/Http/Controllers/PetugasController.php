<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WarehouseModel;
use App\Models\SlotModel;
use App\Models\RackModel;
use App\Models\OrderModel;
use App\Models\OrderDataModel;
use App\Models\OrderItemModel;
use App\Models\OrderExitItemModel;
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


class PetugasController extends Controller
{

	public function index()
	{
		$delivery   = DB::table('tbl_orders')
                        ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
                        ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                        ->where('order_category','Pengiriman')
                        ->orderBy('order_dt','DESC')
                        ->limit('5')
                        ->get();

		$pickup     = DB::table('tbl_orders')
                        ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
                        ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                        ->where('order_category','Pengeluaran')
                        ->orderBy('order_dt','DESC')
                        ->limit('5')
                        ->get();

		$warehouses = DB::table('tbl_warehouses')
                        ->join('tbl_status','tbl_status.id_status','tbl_warehouses.status_id')
                        ->orderby('status_id', 'ASC')
                        ->paginate(4);
		return view('v_petugas.index', compact('warehouses','delivery','pickup'));
	}

    // ========================================
	//     			DAFTAR GUDANG
	// ========================================

    public function showWarehouse(Request $request, $aksi, $id)
    {
        if($aksi == 'daftar') {
            //Daftar Seluruh Gudang
            $warehouses = DB::table('tbl_warehouses')
                            ->join('tbl_status','tbl_status.id_status','tbl_warehouses.status_id')
                            ->paginate(6);

            return view('v_petugas.show_warehouse', compact('warehouses'));

        }elseif($aksi == 'detail') {
            // Detail Gudang
            $warehouse      = DB::table('tbl_warehouses')
                                ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
                                ->where('id_warehouse', $id)
                                ->first();
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

            return view('v_petugas.detail_warehouse', compact('warehouse','warehouse09b','warehouse05b','pallet',
            'rack_pallet_one_lvl1','rack_pallet_one_lvl2','rack_pallet_two_lvl1','rack_pallet_two_lvl2','rack_pallet_three_lvl1',
            'rack_pallet_three_lvl2','rack_pallet_four_lvl1','rack_pallet_four_lvl2',));

        }elseif($aksi == 'slot') {
            // Slot
            $slot   = DB::table('tbl_slots')
                        ->join('tbl_warehouses','tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                        ->where('id_slot', $id)
                        ->get();
            return view('v_petugas.detail_slot', compact('slot'));
        }
    }

	// ========================================
	//     			DAFTAR BARANG
	// ========================================

    public function showItem(Request $request, $aksi, $id)
    {
        if($id == 'masuk'){
            // Daftar barang masuk
            $items = DB::table('tbl_items_incoming')
						->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
						->join('tbl_items_category','tbl_items_category.id_item_category','tbl_orders_data.itemcategory_id')
						->leftjoin('tbl_items_condition','tbl_items_condition.id_item_condition','tbl_items_incoming.in_item_condition')
						->join('tbl_orders','tbl_orders.id_order','tbl_orders_data.order_id')
						->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
						->join('tbl_slots','tbl_slots.id_slot','tbl_orders_data.slot_id')
						->join('tbl_warehouses','.tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
						->where('order_category','Pengiriman')
						->where('in_item_qty','!=', 0)
						->paginate(6);

            return view('v_petugas.show_item', compact('items'));

        }elseif($id == 'keluar'){
            // Daftar barang keluar
            $items = DB::table('tbl_items_exit')
  						->join('tbl_items_incoming','tbl_items_incoming.id_item_incoming','tbl_items_exit.item_incoming_id')
						->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
						->join('tbl_items_category','tbl_items_category.id_item_category','tbl_orders_data.itemcategory_id')
						->leftjoin('tbl_items_condition','tbl_items_condition.id_item_condition','tbl_items_incoming.in_item_condition')
						->join('tbl_orders','tbl_orders.id_order','tbl_items_exit.order_id')
						->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
						->join('tbl_slots','tbl_slots.id_slot','tbl_orders_data.slot_id')
						->join('tbl_warehouses','.tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
						->where('order_category','Pengeluaran')
						->paginate(6);

            return view('v_petugas.show_item', compact('items'));

        }elseif($aksi == 'kelengkapan-barang'){
            // Kelengkapan barang
            $order 	= DB::table('tbl_orders')
					    ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
					    ->where('id_order',$id)
					    ->first();
            $item 	= DB::table('tbl_items_incoming')
                        ->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
                        ->join('tbl_orders','tbl_orders.id_order','tbl_orders_data.order_id')
                        ->where('id_order', $id)
                        ->get();

            return view('v_petugas.create_complete_item', compact('order','item'));

        }elseif($aksi == 'proses-kelengkapan-barang'){
            // Proses tambah kelengkapan barang
            $valImage  	= Validator::make($request->all(), [

            ]);

            if ($valImage->fails()) {
                return redirect('petugas/kelengkapan-barang/'. $id)->with('failed','Format foto tidak sesuai');
            } else {
                $item 		= new OrderItemModel();
                $imgitem 	= $request->item_img;
                $iditem 	= $request->id_item;
                foreach($iditem as $i => $item_id)
                {

                    $getimg = DB::table('tbl_items_incoming')->where('id_item_incoming', $item_id)->first();
                    if ($request->hasfile('item_img')) {
                        if($getimg->in_item_img != ''  && $getimg->in_item_img != null){
                            $file_old = public_path().'\dist\img\data-barang\\' . $getimg->in_item_img;
                            unlink($file_old);
                        }

                        $file       = $request->file('item_img');
                         $filename   = $imgitem[$i]->getClientOriginalName();
                          $imgitem[$i]->move('dist/img/data-barang/', $filename);
                          $item->in_item_img = $filename;
                    } else {
                        $item->in_item_img = null;
                    }
                    $img = $item->in_item_img;
                    OrderItemModel::where('id_item_incoming', $iditem[$i])
                                    ->update(['in_item_img' => $img ]);
                }

                foreach($iditem as $j => $itemid)
                {

                    OrderItemModel::where('id_item_incoming', $itemid)
                        ->update([
                            'in_item_code'  		=> $request->item_code[$i],
                            'in_item_nup'    		=> $request->item_nup[$i],
                            'in_item_purchase'    	=> $request->item_purchase[$i],
                            'in_item_condition'    	=> $request->item_condition[$i],
                            'in_item_description'	=> $request->item_description[$i]
                        ]);
                }
                return redirect('petugas/buat-bast/'. $id);
            }

        }
    }

    // ========================================
	//           ADMINISTRASI BARANG
	// ========================================

    public function showActivity(Request $request, $aksi, $id)
    {
        if($id == 'pengiriman'){
            // Daftar pengiriman barang
            $activity 	= DB::table('tbl_orders_data')
                        	->select('id_order','workunit_name','order_dt','order_tm','order_category','order_emp_name',
                        		     'order_emp_position',DB::raw("sum(total_item) as totalitem"))
                        	->join('tbl_orders','tbl_orders.id_order','tbl_orders_data.order_id')
                        	->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
                        	->groupBy('id_order','workunit_name','order_dt','order_tm','order_category','order_emp_name',
                        		      'order_emp_position')
                        	->where('order_category','Pengiriman')
                        	->orderby('order_dt','DESC')
                        	->get();

		    return view('v_petugas.show_activity', compact('activity'));

        }elseif($id == 'pengeluaran'){
            // Daftar pengeluaran barang
            $activity 	= DB::table('tbl_items_exit')
                        	->select('id_order','workunit_name','order_dt','order_tm','order_category','order_emp_name',
                                     'order_emp_position',DB::raw("sum(ex_item_qty) as totalitem"))
                        	->join('tbl_orders','tbl_orders.id_order','tbl_items_exit.order_id')
                        	->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
                        	->groupBy('id_order','workunit_name','order_dt','order_tm','order_category','order_emp_name',
                                      'order_emp_position')
                        	->where('order_category','Pengeluaran')
                        	->orderby('order_dt','DESC')
                        	->get();

		    return view('v_petugas.show_activity', compact('activity'));

        }
    }

	// ========================================
	// 			BERITA ACARA SERAH TERIMA
	// ========================================

	public function createBAST($id)
	{
		$check 			= DB::table('tbl_orders')->where('id_order',$id)->first();

  		if ($check->order_category == 'Pengiriman') {
  			$item 	= DB::table('tbl_items_incoming')
      					->join('tbl_orders_data', 'tbl_orders_data.id_order_data', 'tbl_items_incoming.order_data_id')
						->join('tbl_items_category','tbl_items_category.id_item_category','tbl_orders_data.itemcategory_id')
						->leftjoin('tbl_items_condition','tbl_items_condition.id_item_condition','tbl_items_incoming.in_item_condition')
     					->join('tbl_orders', 'tbl_orders.id_order', 'tbl_orders_data.order_id')
      					->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_orders_data.slot_id')
      					->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
      					->where('id_order', $id)
     					->get();
  		}elseif ($check->order_category == 'Pengeluaran') {
  			$item 	= DB::table('tbl_items_exit')
  						->join('tbl_items_incoming','tbl_items_incoming.id_item_incoming','tbl_items_exit.item_incoming_id')
  						->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
						->join('tbl_items_category','tbl_items_category.id_item_category','tbl_orders_data.itemcategory_id')
						->leftjoin('tbl_items_condition','tbl_items_condition.id_item_condition','tbl_items_incoming.in_item_condition')
     					->join('tbl_orders', 'tbl_orders.id_order', 'tbl_items_exit.order_id')
      					->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_orders_data.slot_id')
      					->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
      					->where('id_order', $id)
     					->get();
  		}

    	$bast     		= DB::table('tbl_orders')
      						->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
                      		->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
      						->join('users', 'users.id', 'tbl_orders.adminuser_id')
      						->where('id_order', $id)
      						->first();

		return view('v_petugas.create_bast', compact('bast','item'));
	}

	public function printBAST($id)
	{
		$check 			= DB::table('tbl_orders')->where('id_order',$id)->first();

  		if ($check->order_category == 'Pengiriman') {
  			$item 	= DB::table('tbl_items_incoming')
      					->join('tbl_orders_data', 'tbl_orders_data.id_order_data', 'tbl_items_incoming.order_data_id')
						->join('tbl_items_category','tbl_items_category.id_item_category','tbl_orders_data.itemcategory_id')
						->leftjoin('tbl_items_condition','tbl_items_condition.id_item_condition','tbl_items_incoming.in_item_condition')
     					->join('tbl_orders', 'tbl_orders.id_order', 'tbl_orders_data.order_id')
      					->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_orders_data.slot_id')
      					->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
      					->where('id_order', $id)
     					->get();
  		}elseif ($check->order_category == 'Pengeluaran') {
  			$item 	= DB::table('tbl_items_exit')
  						->join('tbl_items_incoming','tbl_items_incoming.id_item_incoming','tbl_items_exit.item_incoming_id')
  						->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
						->join('tbl_items_category','tbl_items_category.id_item_category','tbl_orders_data.itemcategory_id')
						->leftjoin('tbl_items_condition','tbl_items_condition.id_item_condition','tbl_items_incoming.in_item_condition')
     					->join('tbl_orders', 'tbl_orders.id_order', 'tbl_items_exit.order_id')
      					->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_orders_data.slot_id')
      					->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
      					->where('id_order', $id)
     					->get();
  		}

    	$bast     		= DB::table('tbl_orders')
      						->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
                      		->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
      						->join('users', 'users.id', 'tbl_orders.adminuser_id')
      						->where('id_order', $id)
      						->first();

		return view('v_petugas.print_bast', compact('bast','item'));
	}

	// ========================================
	// 			BUAT PENGIRIMAN SINGLE
	// ========================================

	public function creteDeliverySingle()
	{
		$workunit 		= DB::table('tbl_workunits')->get();
		$warehouse 		= DB::table('tbl_warehouses')->where('status_id',1)->get();
		$itemcategory 	= DB::table('tbl_items_category')->get();
		return view('v_petugas.create_single_delivery', compact('workunit','warehouse','itemcategory'));
	}

	public function postDeliverySingle(Request $request)
	{
		// Order =============================================
		$order                          = new OrderModel();
      	$order->id_order                = $request->input('id_order');
	    $order->adminuser_id            = $request->input('adminuser_id');
	    $order->workunit_id             = $request->input('id_workunit');
	    $order->order_emp_name          = strtolower($request->input('order_emp_name'));
	    $order->order_emp_position      = strtolower($request->input('order_emp_position'));
	    $order->order_license_vehicle   = strtoupper($request->input('order_license_vehicle'));
	    $order->order_category          = "Pengiriman";
	    $order->save();

	    // Data Order =============================================
	    $orderid = $request->id_order;
      	$dataid  = $request->id_order_data;
      	foreach ($dataid as $i => $id_order_data) {
        	$order_data[] = [
	          	'id_order_data' 	=> $id_order_data,
	          	'order_id'      	=> $orderid,
	          	'slot_id'       	=> $request->slot_id[$i],
	          	'itemcategory_id'  	=> $request->itemcategory_id[$i],
	          	'deadline'      	=> $request->deadline[$i]
        	];
      	}
      	OrderDataModel::insert($order_data);


      	// Item Order =============================================
      	$itemid = $request->id_item_incoming;
      	foreach ($itemid as $i => $id_item_incoming) {
        		$order_item[] = [
	          	'id_item_incoming' 	=> $id_item_incoming,
	          	'order_data_id'     	=> $request->order_data_id[$i],
	          	'in_item_code'      	=> $request->item_bmn[$i],
	          	'in_item_nup'      	=> $request->item_nup[$i],
	          	'in_item_name'  		=> strtolower($request->item_name[$i]),
	          	'in_item_merk'     	=> strtolower($request->item_merk[$i]),
	          	'in_item_qty'			=> $request->item_qty[$i],
	          	'in_item_unit'			=> strtolower($request->item_unit[$i]),
        		];
      	}
      	OrderItemModel::insert($order_item);

      	// Update Status ==================================================
      	$slotid = $request->slot_id;
      	foreach ($slotid as $i => $slot_id) {
      		$warehouse = DB::table('tbl_slots')
      						->select('id_warehouse')
      						->join('tbl_warehouses','tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
      						->where('id_slot', $slot_id)
      						->first();
      		if($warehouse->id_warehouse == 'G05B'|| $warehouse->id_warehouse == 'G09B')
      		{
	        	SlotModel::where('id_slot', $slot_id)
	          		->update([
	            		'slot_status' => 'Penuh'
	          	]);
	      	}
	    }

		return redirect('petugas/kelengkapan-barang/'. $request->id_order);
	}

	// ========================================
	// 			BUAT PENGELUARAN SINGLE
	// ========================================

	public function createPickupSingle()
	{
		$workunit 		= DB::table('tbl_workunits')->get();
		$warehouse 		= DB::table('tbl_warehouses')->where('status_id',1)->get();
		$itemcategory 	= DB::table('tbl_items_category')->get();
		return view('v_petugas.create_single_pickup', compact('workunit','warehouse','itemcategory'));
	}

	public function postPickupSingle(Request $request)
	{
		// Order =============================================
		$order                          = new OrderModel();
      	$order->id_order                = $request->input('id_order');
	    $order->adminuser_id            = $request->input('adminuser_id');
	    $order->workunit_id             = $request->input('id_workunit');
	    $order->order_emp_name          = strtolower($request->input('order_emp_name'));
	    $order->order_emp_position      = strtolower($request->input('order_emp_position'));
	    $order->order_license_vehicle   = strtoupper($request->input('order_license_vehicle'));
	    $order->order_category          = "Pengeluaran";
	    $order->save();

	    // Order Detail Item ==================================
	    $itemid = $request->id_item;
      	foreach ($itemid as $i => $item_id) {
      		$item_in  = (int)$request->item_in_qty[$i];
      		$item_out = (int)$request->item_out_qty[$i];
      		$res_qty  = $item_in - $item_out;

      		$update_qty = OrderItemModel::where('id_item_incoming', $item_id)
      						->update([ 'in_item_qty' => $res_qty ]);

      		$insert_ext           = new OrderExitItemModel();
      		$insert_ext->id_item_exit 	  = $request->id_item_exit[$i];
      		$insert_ext->order_id 		  = $request->id_order;
      		$insert_ext->item_incoming_id = $item_id;
      		$insert_ext->ex_item_qty 	  = $request->item_out_qty[$i];
      		$insert_ext->save();
	    }
	    return redirect('petugas/buat-bast/'. $request->id_order);
	}

	// ========================================
	// 	   PROSES SURAT PERINTAH PENGIRIMAN
	// ========================================





	// ========================================
	// 				  SELECT 2
	// ========================================
	public function select2Workunit(Request $request)
    {
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

	public function select2Item(Request $request)
    {
    	$search 	= $request->search;
    	$workunit 	= $request->workunit;
    	$item 		= $request->item;
    	if($item == [])
    	{
    	  if($search == ''){
    		  $item = DB::table('tbl_items_incoming')
    				->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
    				->join('tbl_orders','tbl_orders.id_order','tbl_orders_data.order_id')
    				->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
    				->where('id_workunit', $workunit)
    				->get();
    	  }else{
    		  $item = DB::table('tbl_items_incoming')
    				->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
    				->join('tbl_orders','tbl_orders.id_order','tbl_orders_data.order_id')
    				->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
    				->where('in_item_name', 'like', '%' .$search . '%')->get();
    	  }
    	}else{
    		if($search == ''){
    		  $item = DB::table('tbl_items_incoming')
    				->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
    				->join('tbl_orders','tbl_orders.id_order','tbl_orders_data.order_id')
    				->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
    				->whereNotIn('id_item_incoming', $item)
    				->where('id_workunit', $workunit)
    				->get();
    	    }else{
    		  $item = DB::table('tbl_items_incoming')
    				->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
    				->join('tbl_orders','tbl_orders.id_order','tbl_orders_data.order_id')
    				->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
    				->whereNotIn('id_item_incoming', $item)
    				->where('in_item_name', 'like', '%' .$search . '%')->get();
    	    }
    	}

    	$response = array();
    	foreach($item as $data){
    	  $response[] = array(
    	 	"id"    =>  $data->id_item_incoming,
    	 	"text"  =>  $data->in_item_name
    	  );
    	}

    	return response()->json($response);
    }

    // ========================================
	// 				  JSON
	// ========================================

    public function jsonGetDetailItem(Request $request)
    {
        $result = DB::table('tbl_items_incoming')
    				->join('tbl_orders_data','tbl_orders_data.id_order_data','tbl_items_incoming.order_data_id')
    				->join('tbl_orders','tbl_orders.id_order','tbl_orders_data.order_id')
    				->join('tbl_workunits','tbl_workunits.id_workunit','tbl_orders.workunit_id')
    				->join('tbl_slots','tbl_slots.id_slot','tbl_orders_data.slot_id')
    				->join('tbl_warehouses','tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
    				->where('id_item_incoming', $request->itemcode)
    				->get();

        return response()->json($result);
    }

    public function jsonGetMainunit(Request $request)
    {
        $result = DB::table('tbl_workunits')
                    ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                    ->where('id_workunit', $request->workunit)
                    ->pluck('id_mainunit','mainunit_name');
        return response()->json($result);
    }

    public function jsonGetSlot(Request $request)
    {
    	if ($request->dataslot == []) {
    		$result = DB::table('tbl_slots')
                    ->join('tbl_warehouses','tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                    ->where('id_warehouse', $request->warehouseid)
                    ->where('slot_status','!=','Penuh')
                    ->pluck('id_slot','id_slot');
    	}elseif($request->warehouseid != 'G05B' && $request->warehouseid != 'G09B') {
    		$result = DB::table('tbl_slots')
                    ->join('tbl_warehouses','tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                    ->where('id_warehouse', $request->warehouseid)
                    ->where('slot_status','!=','Penuh')
                    ->pluck('id_slot','id_slot');
    	}else{
    		$result = DB::table('tbl_slots')
                    ->join('tbl_warehouses','tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                    ->whereNotIn('id_slot', $request->dataslot)
                    ->where('id_warehouse', $request->warehouseid)
                    ->where('slot_status','!=','Penuh')
                    ->pluck('id_slot','id_slot');
    	}
    	return response()->json($result);
    }

    public function jsonGetWarehouse(Request $request)
  	{
  		$category 	= DB::table('tbl_items_category')->get();
    	$warehouse  = DB::table('tbl_warehouses')->where('status_id', 1)->get();
    	$slot 		= DB::table('tbl_slots')->get();

	   $array['category'] 	= $category;
	   $array['warehouse'] = $warehouse;
	   $array['slot'] 		= $slot;

	   return response()->json($array);
  	}

}
