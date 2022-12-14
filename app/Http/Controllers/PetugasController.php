<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WarehouseModel;
use App\Models\SlotModel;
use App\Models\ItemModel;
use App\Models\OrderModel;
use App\Models\OrderDataModel;
use App\Models\OrderItemModel;
use App\Models\OrderExitItemModel;
use App\Models\ScreeningModel;
use App\Models\User;
use App\Models\WarrentModel;
use App\Models\HistoryModel;
use App\Models\WarrentExitModel;
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
        $cekScreening   = DB::table('tbl_items_screening')->join('tbl_warrents', 'id_warrent', 'warrent_id')->count();
        $delivery       = DB::table('tbl_orders')
            ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
            ->join('tbl_mainunits', 'tbl_mainunits.id_mainunit', 'tbl_workunits.mainunit_id')
            ->where('order_category', 'penyimpanan')
            ->orderBy('order_dt', 'DESC')
            ->limit('5')
            ->get();

        $pickup         = DB::table('tbl_orders')
            ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
            ->join('tbl_mainunits', 'tbl_mainunits.id_mainunit', 'tbl_workunits.mainunit_id')
            ->where('order_category', 'pengeluaran')
            ->orderBy('order_dt', 'DESC')
            ->limit('5')
            ->get();

        $warrent        = DB::table('tbl_warrents')
            ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_warrents.workunit_id')
            ->orderBy('warr_date', 'DESC')
            ->where('warr_status', '!=', 'selesai')
            ->get();

        return view('v_petugas.index', compact('cekScreening', 'delivery', 'pickup', 'warrent'));
    }

    // ========================================
    //     			SURAT PERINTAH
    // ========================================

    public function showWarrent(Request $request, $aksi, $id)
    {
        if ($aksi == 'penapisan') {
            $category = DB::table('tbl_warrents')->where('id_warrent', $id)->first();
            if ($category->warr_purpose == 'penyimpanan') {
                $warrent = DB::table('tbl_warrents')->where('id_warrent', $id)->join('tbl_workunits', 'id_workunit', 'workunit_id')->first();
                $item    = DB::table('tbl_warrents_entry')
                    ->join('tbl_warrents', 'id_warrent', 'warrent_id')
                    ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->where('warrent_id', $id)
                    ->get();
            } else {
                $warrent = DB::table('tbl_warrents')->where('id_warrent', $id)->join('tbl_workunits', 'id_workunit', 'workunit_id')->first();
                $item    = DB::table('tbl_warrents_exit')
                    ->join('tbl_warrents', 'id_warrent', 'warrent_id')
                    ->join('tbl_items', 'id_item', 'item_id')
                    ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->where('warrent_id', $id)
                    ->get();
            }

            return view('v_petugas.screening_item', compact('warrent', 'item'));
        } elseif ($aksi == 'proses-penapisan') {
            // Proses Order
            $cekCtg     = DB::table('tbl_warrents')->where('id_warrent', $id)->first();
            $cekOrder   = DB::table('tbl_orders')->count();
            if ($cekCtg->warr_purpose == 'penyimpanan') {
                $idOrder    = 'PBM_' . Carbon::now()->format('ddmy') . $cekOrder;
            } else {
                $idOrder    = 'PBK_' . Carbon::now()->format('ddmy') . $cekOrder;
            }
            $order = new OrderModel();
            $order->id_order                = $idOrder;
            $order->warrent_id              = $id;
            $order->adminuser_id            = Auth::user()->id;
            $order->workunit_id             = $request->input('workunit_id');
            $order->order_license_vehicle   = $request->input('license_vehicle');
            $order->order_emp_name          = $request->input('emp_name');
            $order->order_emp_position      = $request->input('emp_position');
            $order->order_total_item        = $request->input('total_item');
            $order->order_category          = $request->input('category');
            $order->order_tm                = Carbon::now();
            $order->order_dt                = Carbon::now();
            $order->save();
            // Proses Penapisan
            $cekScreening = DB::table('tbl_items_screening')->count();
            $idItem       = $request->item_id;
            foreach ($idItem as $i => $item_id) {
                $idScreening  = Carbon::now()->format('dmy') . $cekScreening + $i;
                $screening = new ScreeningModel();
                $screening->id_item_screening   = $idScreening;
                $screening->warrent_id          = $id;
                $screening->order_id            = $idOrder;
                $screening->item_id             = $item_id;
                $screening->item_volume         = $request->item_volume[$i];
                $screening->item_received       = $request->item_received[$i];
                $screening->status_screening    = $request->status_screening[$i];
                $screening->screening_notes     = $request->screening_notes[$i];
                $screening->approve_petugas     = 1;
                $screening->screening_date      = Carbon::now();
                $screening->save();
            }
            // Update status penapisan
            WarrentModel::where('id_warrent', $id)->update(['warr_status' => 'konfirmasi']);

            return redirect('petugas/dashboard')->with('success', 'Berhasil melakukan penapisan');
        }
    }

    // ========================================
    //     			DAFTAR GUDANG
    // ========================================

    public function showWarehouse(Request $request, $aksi, $id)
    {
        if ($aksi == 'daftar') {
            //Daftar Seluruh Gudang
            $warehouses = DB::table('tbl_warehouses')
                ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
                ->paginate(6);

            return view('v_petugas.show_warehouse', compact('warehouses'));
        } elseif ($aksi == 'detail') {
            // Detail Gudang
            $warehouse      = DB::table('tbl_warehouses')
                ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
                ->where('id_warehouse', $id)
                ->first();
            $warehouse09b   = DB::table('tbl_warehouses')
                ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
                ->where('id_warehouse', 'G09B')
                ->get();
            $warehouse05b   = DB::table('tbl_warehouses')
                ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
                ->where('id_warehouse', 'G05B')
                ->get();
            $pallet         = DB::table('tbl_slots_names')
                ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_slots_names.pallet_id')
                ->get();
            $slot           = DB::table('tbl_slots')
                ->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
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

            return view('v_petugas.detail_warehouse', compact(
                'warehouse',
                'warehouse09b',
                'warehouse05b',
                'pallet',
                'slot',
                'rack_pallet_one_lvl1',
                'rack_pallet_one_lvl2',
                'rack_pallet_two_lvl1',
                'rack_pallet_two_lvl2',
                'rack_pallet_three_lvl1',
                'rack_pallet_three_lvl2',
                'rack_pallet_four_lvl1',
                'rack_pallet_four_lvl2',
            ));
        } elseif ($aksi == 'slot') {
            $itemCategory = DB::table('tbl_items_category')->get();
            // Slot
            $slot   = DB::table('tbl_slots')
                ->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
                ->where('id_slot', $id)
                ->first();

            $items  = DB::table('tbl_orders_data')
                ->join('tbl_slots', 'id_slot', 'slot_id')
                ->join('tbl_warehouses', '.id_warehouse', 'warehouse_id')
                ->join('tbl_items', 'id_item', 'item_id')
                ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                ->join('tbl_items_condition', 'id_item_condition', '.item_condition_id')
                ->join('tbl_orders', 'id_order', 'order_id')
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->where('order_category', 'penyimpanan')
                ->where('slot_id', $id)
                ->get();

            $itemExit   = DB::table('tbl_historys')
                ->join('tbl_orders', 'id_order', 'tbl_historys.order_id')
                ->join('tbl_items', 'id_item', 'item_id')
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                ->where('order_category', 'pengeluaran')
                ->where('slot_id', $id)
                ->get();

            return view('v_petugas.detail_slot', compact('slot', 'items', 'itemExit', 'itemCategory'));
        }
    }

    // ========================================
    //     			DAFTAR BARANG
    // ========================================

    public function showItem(Request $request, $aksi, $id)
    {
        if ($id == 'masuk') {
            // Daftar barang masuk
            $itemEntry = DB::table('tbl_items')
                ->join('tbl_orders', 'id_order', 'order_id')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->where('order_category', 'penyimpanan')
                ->get();
            return view('v_petugas.show_item_entry', compact('itemEntry'));
        } elseif ($id == 'keluar') {
            // Daftar barang keluar
            $itemExit   = DB::table('tbl_historys')
                ->join('tbl_orders', 'id_order', 'tbl_historys.order_id')
                ->join('tbl_items', 'id_item', 'item_id')
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->where('order_category', 'pengeluaran')
                ->get();
            return view('v_petugas.show_item_exit', compact('id', 'itemExit'));
        } elseif ($aksi == 'detail') {
            $item     = DB::table('tbl_items')
                ->join('tbl_orders', 'id_order', 'order_id')
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->leftjoin('tbl_warrents', 'id_warrent', 'warrent_id')
                ->leftjoin('tbl_appletters', 'id_app_letter', 'appletter_id')
                ->where('id_item', $id)->first();

            $items    = DB::table('tbl_orders_data')
                ->join('tbl_items', 'id_item', 'item_id')
                ->join('tbl_orders', 'id_order', 'order_id')
                ->where('item_id', $id)
                ->get();

            $itemExit = DB::table('tbl_historys')->select(DB::raw('sum(hist_total_item) as total_exit'))
                ->join('tbl_orders', 'id_order', 'order_id')
                ->where('id_order', 'like', '%' . 'PBK_' . '%')
                ->where('item_id', $id)->first();

            return view('v_petugas.detail_item', compact('item', 'items', 'itemExit'));
        } elseif ($aksi == 'kelengkapan-barang') {
            // Kelengkapan barang
            $order     = DB::table('tbl_orders')
                ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
                ->where('id_order', $id)
                ->first();
            $item     = DB::table('tbl_items_incoming')
                ->join('tbl_orders_data', 'tbl_orders_data.id_order_data', 'tbl_items_incoming.order_data_id')
                ->join('tbl_orders', 'tbl_orders.id_order', 'tbl_orders_data.order_id')
                ->where('id_order', $id)
                ->orderBy('in_item_name', 'ASC')
                ->get();

            return view('v_petugas.create_complete_item', compact('order', 'item'));
        } elseif ($aksi == 'proses-kelengkapan-barang') {
            // Proses tambah kelengkapan barang
            $valImage      = Validator::make($request->all(), []);

            if ($valImage->fails()) {
                return redirect('petugas/barang/kelengkapan-barang/' . $id)->with('failed', 'Format foto tidak sesuai');
            } else {
                $item         = new OrderItemModel();
                $imgitem     = $request->item_img;
                $iditem     = $request->id_item;
                foreach ($iditem as $i => $item_id) {

                    $getimg = DB::table('tbl_items_incoming')->where('id_item_incoming', $item_id)->first();
                    if ($request->hasfile('item_img')) {
                        if ($getimg->in_item_img != ''  && $getimg->in_item_img != null) {
                            $file_old = public_path() . '\dist\img\data-barang\\' . $getimg->in_item_img;
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
                        ->update(['in_item_img' => $img]);
                }

                foreach ($iditem as $j => $itemid) {

                    OrderItemModel::where('id_item_incoming', $itemid)
                        ->update([
                            'in_item_code'          => $request->item_code[$i],
                            'in_item_nup'            => $request->item_nup[$i],
                            'in_item_purchase'        => $request->item_purchase[$i],
                            'in_item_condition'        => $request->item_condition[$i],
                            'in_item_description'    => $request->item_description[$i]
                        ]);
                }
                return redirect('petugas/buat-bast/' . $id);
            }
        } elseif ($aksi == 'cari') {
            $cekCtg = DB::table('tbl_orders')->where('id_order', 'like', '%' . $id . '%')->first();
            if ($cekCtg->order_category == 'penyimpanan') {
                $itemEntry  = DB::table('tbl_items')
                    ->join('tbl_orders', 'id_order', 'order_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                    ->where('id_order', $id)
                    ->get();

                return view('v_petugas.show_item_entry', compact('itemEntry'));
            } else {
                $itemExit   = DB::table('tbl_historys')
                    ->join('tbl_orders', 'id_order', 'tbl_historys.order_id')
                    ->join('tbl_items', 'id_item', 'item_id')
                    ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->where('id_order', $id)
                    ->get();
                return view('v_petugas.show_item_exit', compact('itemExit'));
            }
        } elseif ($aksi == 'penyimpanan') {
            $warrent   = DB::table('tbl_orders')->where('warrent_id', $id)->first();
            $warehouse = DB::table('tbl_warehouses')->where('status_id', '1')->get();
            if ($warrent != null) {
                $proses = 'satker';
                $order  = DB::table('tbl_orders')->where('warrent_id', $id)->first();
                $item   = DB::table('tbl_warrents_entry')
                    ->select('id_warr_entry as id_item', 'warr_item_name as item_name')
                    ->join('tbl_warrents', 'id_warrent', 'warrent_id')
                    ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->where('id_warrent', $id)
                    ->get();
            } else {
                $proses = 'petugas';
                $order  = DB::table('tbl_orders')->where('id_order', $id)->first();
                $item   = DB::table('tbl_items')
                    ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->join('tbl_orders', 'id_order', 'order_id')
                    ->where('id_order', $id)
                    ->get();
            }

            return view('v_petugas.process_delivery', compact('order', 'warehouse', 'item', 'proses'));
        } elseif ($aksi == 'pengeluaran') {
            $order      = DB::table('tbl_orders')->where('warrent_id', $id)->first();
            $warehouse  = DB::table('tbl_warehouses')->where('status_id', '1')->get();
            $item       = DB::table('tbl_warrents_exit')
                ->join('tbl_warrents', 'id_warrent', 'warrent_id')
                ->join('tbl_items', 'id_item', 'item_id')
                ->join('tbl_slots', 'id_slot', 'slot_id')
                ->join('tbl_warehouses', 'id_warehouse', 'warehouse_id')
                ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->where('id_warrent', $id)
                ->get();

            return view('v_petugas.process_pickup', compact('id', 'order', 'warehouse', 'item'));
        } elseif ($aksi == 'proses-simpan') {
            $getItem    = DB::table('tbl_warrents_entry')->where('warrent_id', $request->warrent_id)->get();
            if ($getItem != []) {
                foreach ($getItem as $i => $warrItem) {
                    $item = new ItemModel();
                    $item->id_item            = Str::replace('warr_entry_', 'ITEM', $warrItem->id_warr_entry);
                    $item->order_id           = $id;
                    $item->item_category_id   = $warrItem->item_category_id;
                    $item->item_code          = $warrItem->warr_item_code;
                    $item->item_nup           = $warrItem->warr_item_nup;
                    $item->item_name          = $warrItem->warr_item_name;
                    $item->item_description   = $warrItem->warr_item_description;
                    $item->item_qty           = $warrItem->warr_item_qty;
                    $item->item_unit          = $warrItem->warr_item_unit;
                    $item->item_condition_id  = $warrItem->item_condition_id;
                    $item->item_unit          = $warrItem->warr_item_unit;
                    $item->save();
                }
            }

            $idSlot       = $request->slot_id;
            foreach ($idSlot as $i => $slot_id) {
                if ($getItem != []) {
                    $itemid = Str::replace('warr_entry_', 'ITEM', $request->item_id[$i]);
                } else {
                    $itemid = $request->item_id[$i];
                }

                $data = new OrderDataModel();
                $data->id_order_data = $request->idData[$i];
                $data->item_id       = $itemid;
                $data->slot_id       = $slot_id;
                $data->deadline      = $request->deadline;
                $data->total_item    = $request->item_qty[$i];
                $data->save();

                $hist = new HistoryModel();
                $hist->id_history       = 'hist_' . Carbon::now()->format('dmy') . rand(000, 999);
                $hist->hist_date        = Carbon::now();
                $hist->order_id         = $id;
                $hist->item_id          = $itemid;
                $hist->slot_id          = $slot_id;
                $hist->hist_total_item  = $request->item_qty[$i];
                $hist->save();

                SlotModel::where('id_slot', $slot_id)->update([
                    'slot_status' => $request->slot_status[$i]
                ]);
            }

            WarrentModel::where('id_warrent', $request->warrent_id)->update(['warr_status' => 'selesai']);

            return redirect('petugas/buat-bast/' . $id)->with('Berhasil menyimpan barang');
        } elseif ($aksi == 'proses-ambil') {
            $idSlotUpd       = $request->slot_id;
            foreach ($idSlotUpd as $i => $slot_id) {
                $data = OrderDataModel::select('id_order_data as id', 'total_item')
                    ->join('tbl_items', 'id_item', 'item_id')
                    ->where('tbl_items.order_id', 'like', 'PBM_' . '%')
                    ->where('slot_id', $slot_id)
                    ->where('item_id', $request->item_id[$i])
                    ->first();

                OrderDataModel::where('id_order_data', $data->id)->update([
                    'total_item' => $data->total_item - $request->item_pick[$i]
                ]);
            }

            $idSlotAdd       = $request->slot_id;

            foreach ($idSlotAdd as $i => $slot_id) {
                $hist = new HistoryModel();
                $hist->id_history       = 'hist_' . Carbon::now()->format('dmyhis') . $i;
                $hist->hist_date        = Carbon::now();
                $hist->order_id         = $id;
                $hist->item_id          = $request->item_id[$i];
                $hist->slot_id          = $request->slot_id[$i];
                $hist->hist_total_item  = $request->item_pick[$i];
                $hist->save();
            }

            $pick  = WarrentExitModel::select('warrent_id', 'item_id', DB::raw('sum(warr_item_pick) as total'))
                ->where('warrent_id', $request->warrent_id)
                ->groupBy('warrent_id', 'item_id')
                ->get();

            foreach ($pick as $item_pick) {
                $stock = ItemModel::where('id_item', $item_pick->item_id)->first();
                ItemModel::where('id_item', $item_pick->item_id)->update([
                    'item_qty' => $stock->item_qty - $item_pick->total
                ]);
            }


            WarrentModel::where('id_warrent', $request->warrent_id)->update(['warr_status' => 'selesai']);
            return redirect('petugas/buat-bast/' . $id)->with('Berhasil menyimpan barang');
        }
    }

    // ========================================
    //           ADMINISTRASI BARANG
    // ========================================

    public function showActivity(Request $request, $aksi, $id)
    {
        if ($aksi == 'daftar') {
            if ($id == 'penyimpanan') {
                $activity    = DB::table('tbl_orders')
                    ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
                    ->where('order_category', 'penyimpanan')
                    ->orderby('order_dt', 'DESC')
                    ->get();
            } else {
                $activity    = DB::table('tbl_orders')
                    ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
                    ->where('order_category', 'pengeluaran')
                    ->orderby('order_dt', 'DESC')
                    ->get();
            }
            return view('v_petugas.show_activity', compact('id', 'activity'));
        }

        if ($aksi == 'buat') {
            if ($id == 'penyimpanan') {
                $workunit     = DB::table('tbl_workunits')->get();
                $warehouse    = DB::table('tbl_warehouses')->where('status_id', 1)->get();
                $itemcategory = DB::table('tbl_items_category')->get();

                return view('v_petugas.create_delivery', compact('workunit', 'warehouse', 'itemcategory'));
            }
        }

        if ($aksi == 'proses') {
            if ($id == 'penyimpanan') {
                $order = new OrderModel();
                $order->id_order              = $request->id_order;
                $order->adminuser_id          = Auth::user()->id;
                $order->workunit_id           = $request->id_workunit;
                $order->order_license_vehicle = $request->order_license_vehicle;
                $order->order_emp_name        = $request->order_emp_name;
                $order->order_emp_position    = $request->order_emp_position;
                $order->order_total_item      = count($request->item_name);
                $order->order_category        = 'penyimpanan';
                $order->order_tm              = Carbon::now();
                $order->order_dt              = $request->order_dt;
                $order->save();

                $item = $request->id_item;
                foreach ($item as $i => $item_id) {
                    $item = new ItemModel();
                    $item->id_item             = $item_id;
                    $item->order_id            = $request->id_order;
                    $item->item_category_id    = $request->item_category_id[$i];
                    $item->item_code           = $request->item_code[$i];
                    $item->item_nup            = $request->item_nup[$i];
                    $item->item_name           = $request->item_name[$i];
                    $item->item_description    = $request->item_description[$i];
                    $item->item_qty            = $request->item_qty[$i];
                    $item->item_unit           = $request->item_unit[$i];
                    $item->item_purchase       = $request->item_purchase[$i];
                    $item->item_condition_id   = $request->item_condition_id[$i];
                    $item->item_status_id      = $request->item_status_id[$i];
                    $item->save();
                }

                return redirect('petugas/barang/penyimpanan/' . $request->id_order)->with('sukses', 'Berhasil menginput barang');
            }
        }
    }

    // ========================================
    // 			BERITA ACARA SERAH TERIMA
    // ========================================

    public function createBAST($id)
    {
        $check          = DB::table('tbl_orders')->where('id_order', $id)->first();

        if ($check->order_category == 'penyimpanan') {
            $item    = DB::table('tbl_orders_data')
                ->join('tbl_items', 'id_item', 'item_id')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->join('tbl_orders', 'tbl_orders.id_order', 'tbl_items.order_id')
                ->join('tbl_slots', 'id_slot', 'slot_id')
                ->join('tbl_warehouses', 'id_warehouse', 'warehouse_id')
                ->orderBy('item_name', 'ASC')
                ->where('id_order', $id)
                ->get();
        } elseif ($check->order_category == 'pengeluaran') {
            $item    = DB::table('tbl_historys')
                ->select('tbl_items.*', 'tbl_slots.*', 'tbl_items_condition.*', 'tbl_warehouses.*', 'hist_total_item as total_item')
                ->join('tbl_items', 'id_item', 'item_id')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->join('tbl_orders', 'id_order', 'tbl_historys.order_id')
                ->join('tbl_slots', 'id_slot', 'slot_id')
                ->join('tbl_warehouses', 'id_warehouse', 'warehouse_id')
                ->where('id_order', $id)
                ->get();
        }

        $bast = DB::table('tbl_orders')
            ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
            ->join('tbl_mainunits', 'tbl_mainunits.id_mainunit', 'tbl_workunits.mainunit_id')
            ->join('users', 'users.id', 'tbl_orders.adminuser_id')
            ->where('id_order', $id)
            ->first();

        return view('v_petugas.create_bast', compact('bast', 'item'));
    }

    public function printBAST($id)
    {
        $check          = DB::table('tbl_orders')->where('id_order', $id)->first();

        if ($check->order_category == 'penyimpanan') {
            $item    = DB::table('tbl_orders_data')
                ->join('tbl_items', 'id_item', 'item_id')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->join('tbl_orders', 'id_order', 'tbl_items.order_id')
                ->join('tbl_slots', 'id_slot', 'slot_id')
                ->join('tbl_warehouses', 'id_warehouse', 'warehouse_id')
                ->where('id_order', $id)
                ->get();
        } elseif ($check->order_category == 'pengeluaran') {
            $item    = DB::table('tbl_historys')
                ->select('tbl_items.*', 'tbl_slots.*', 'tbl_items_condition.*', 'tbl_warehouses.*', 'hist_total_item as total_item')
                ->join('tbl_items', 'id_item', 'item_id')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->join('tbl_orders', 'id_order', 'tbl_historys.order_id')
                ->join('tbl_slots', 'id_slot', 'slot_id')
                ->join('tbl_warehouses', 'id_warehouse', 'warehouse_id')
                ->where('id_order', $id)
                ->get();
        }

        $bast           = DB::table('tbl_orders')
            ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
            ->join('tbl_mainunits', 'tbl_mainunits.id_mainunit', 'tbl_workunits.mainunit_id')
            ->join('users', 'users.id', 'tbl_orders.adminuser_id')
            ->where('id_order', $id)
            ->first();

        return view('v_petugas.print_bast', compact('bast', 'item'));
    }

    // ========================================
    // 			BUAT PENYIMPANAN SINGLE
    // ========================================

    public function creteDeliverySingle()
    {
        $workunit       = DB::table('tbl_workunits')->get();
        $warehouse       = DB::table('tbl_warehouses')->where('status_id', 1)->get();
        $itemcategory    = DB::table('tbl_items_category')->get();
        return view('v_petugas.create_single_delivery', compact('workunit', 'warehouse', 'itemcategory'));
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
        $order->order_category          = "penyimpanan";
        $order->save();

        // Data Order =============================================
        $orderid = $request->id_order;
        $dataid  = $request->id_order_data;
        foreach ($dataid as $i => $id_order_data) {
            $order_data[] = [
                'id_order_data'    => $id_order_data,
                'order_id'         => $orderid,
                'slot_id'          => $request->slot_id[$i],
                'itemcategory_id'     => $request->itemcategory_id[$i],
                'deadline'         => $request->deadline[$i]
            ];
        }
        OrderDataModel::insert($order_data);


        // Item Order =============================================
        $itemid = $request->id_item_incoming;
        foreach ($itemid as $i => $id_item_incoming) {
            $order_item[] = [
                'id_item_incoming'    => $id_item_incoming,
                'order_data_id'        => $request->order_data_id[$i],
                'in_item_code'         => $request->item_bmn[$i],
                'in_item_nup'         => $request->item_nup[$i],
                'in_item_name'        => strtolower($request->item_name[$i]),
                'in_item_merk'        => strtolower($request->item_merk[$i]),
                'in_item_qty'         => $request->item_qty[$i],
                'in_item_unit'         => strtolower($request->item_unit[$i]),
            ];
        }
        OrderItemModel::insert($order_item);

        // Update Status ==================================================
        $slotid = $request->slot_id;
        foreach ($slotid as $i => $slot_id) {
            $warehouse = DB::table('tbl_slots')
                ->select('id_warehouse')
                ->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
                ->where('id_slot', $slot_id)
                ->first();
            if ($warehouse->id_warehouse == 'G05B' || $warehouse->id_warehouse == 'G09B') {
                SlotModel::where('id_slot', $slot_id)
                    ->update([
                        'slot_status' => 'Penuh'
                    ]);
            }
        }

        return redirect('petugas/kelengkapan-barang/' . $request->id_order);
    }

    // ========================================
    // 			BUAT PENGELUARAN SINGLE
    // ========================================

    public function createPickupSingle()
    {
        $workunit       = DB::table('tbl_workunits')->get();
        $warehouse       = DB::table('tbl_warehouses')->where('status_id', 1)->get();
        $itemcategory    = DB::table('tbl_items_category')->get();
        return view('v_petugas.create_single_pickup', compact('workunit', 'warehouse', 'itemcategory'));
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
                ->update(['in_item_qty' => $res_qty]);

            $insert_ext           = new OrderExitItemModel();
            $insert_ext->id_item_exit      = $request->id_item_exit[$i];
            $insert_ext->order_id         = $request->id_order;
            $insert_ext->item_incoming_id = $item_id;
            $insert_ext->ex_item_qty      = $request->item_out_qty[$i];
            $insert_ext->save();
        }
        return redirect('petugas/buat-bast/' . $request->id_order);
    }



    // ========================================
    // 				  SELECT 2
    // ========================================

    public function select2(Request $request, $id)
    {
        $search = $request->search;
        if ($id == 'list-category') {
            if ($search == '') {
                $itemcategory = DB::table('tbl_items_category')->get();
            } else {
                $itemcategory = DB::table('tbl_items_category')->where('item_category_name', 'like', '%' . $search . '%')->get();
            }
        }

        $response = array();
        foreach ($itemcategory as $data) {
            $response[] = array(
                "id"    =>  $data->id_item_category,
                "text"  =>  $data->id_item_category . ' - ' . $data->item_category_name
            );
        }

        return response()->json($response);
    }

    public function select2Workunit(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $workunit = DB::table('tbl_workunits')->get();
        } else {
            $workunit = DB::table('tbl_workunits')->where('workunit_name', 'like', '%' . $search . '%')->get();
        }

        $response = array();
        foreach ($workunit as $data) {
            $response[] = array(
                "id"    =>  $data->id_workunit,
                "text"  =>  $data->id_workunit . ' - ' . $data->workunit_name
            );
        }

        return response()->json($response);
    }

    public function select2Item(Request $request)
    {
        $search    = $request->search;
        $workunit    = $request->workunit;
        $item       = $request->item;
        if ($item == []) {
            if ($search == '') {
                $item = DB::table('tbl_items_incoming')
                    ->join('tbl_orders_data', 'tbl_orders_data.id_order_data', 'tbl_items_incoming.order_data_id')
                    ->join('tbl_orders', 'tbl_orders.id_order', 'tbl_orders_data.order_id')
                    ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
                    ->where('id_workunit', $workunit)
                    ->get();
            } else {
                $item = DB::table('tbl_items_incoming')
                    ->join('tbl_orders_data', 'tbl_orders_data.id_order_data', 'tbl_items_incoming.order_data_id')
                    ->join('tbl_orders', 'tbl_orders.id_order', 'tbl_orders_data.order_id')
                    ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
                    ->where('in_item_name', 'like', '%' . $search . '%')->get();
            }
        } else {
            if ($search == '') {
                $item = DB::table('tbl_items_incoming')
                    ->join('tbl_orders_data', 'tbl_orders_data.id_order_data', 'tbl_items_incoming.order_data_id')
                    ->join('tbl_orders', 'tbl_orders.id_order', 'tbl_orders_data.order_id')
                    ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
                    ->whereNotIn('id_item_incoming', $item)
                    ->where('id_workunit', $workunit)
                    ->get();
            } else {
                $item = DB::table('tbl_items_incoming')
                    ->join('tbl_orders_data', 'tbl_orders_data.id_order_data', 'tbl_items_incoming.order_data_id')
                    ->join('tbl_orders', 'tbl_orders.id_order', 'tbl_orders_data.order_id')
                    ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
                    ->whereNotIn('id_item_incoming', $item)
                    ->where('in_item_name', 'like', '%' . $search . '%')->get();
            }
        }

        $response = array();
        foreach ($item as $data) {
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
            ->join('tbl_orders_data', 'tbl_orders_data.id_order_data', 'tbl_items_incoming.order_data_id')
            ->join('tbl_orders', 'tbl_orders.id_order', 'tbl_orders_data.order_id')
            ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_orders.workunit_id')
            ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_orders_data.slot_id')
            ->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
            ->where('id_item_incoming', $request->itemcode)
            ->get();

        return response()->json($result);
    }

    public function jsonGetMainunit(Request $request)
    {
        $result = DB::table('tbl_workunits')
            ->join('tbl_mainunits', 'tbl_mainunits.id_mainunit', 'tbl_workunits.mainunit_id')
            ->where('id_workunit', $request->workunit)
            ->pluck('id_mainunit', 'mainunit_name');
        return response()->json($result);
    }

    public function jsonGetSlot(Request $request)
    {
        if ($request->dataslot == []) {
            $result = DB::table('tbl_slots')
                ->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
                ->where('id_warehouse', $request->warehouseid)
                ->where('slot_status', '!=', 'Penuh')
                ->pluck('id_slot', 'id_slot');
        } elseif ($request->warehouseid != 'G05B' && $request->warehouseid != 'G09B') {
            $result = DB::table('tbl_slots')
                ->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
                ->where('id_warehouse', $request->warehouseid)
                ->where('slot_status', '!=', 'Penuh')
                ->pluck('id_slot', 'id_slot');
        } else {
            $result = DB::table('tbl_slots')
                ->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
                ->whereNotIn('id_slot', $request->dataslot)
                ->where('id_warehouse', $request->warehouseid)
                ->where('slot_status', '!=', 'Penuh')
                ->pluck('id_slot', 'id_slot');
        }
        return response()->json($result);
    }

    public function jsonGetWarehouse(Request $request)
    {
        $category    = DB::table('tbl_items_category')->get();
        $warehouse  = DB::table('tbl_warehouses')->where('status_id', 1)->get();
        $slot       = DB::table('tbl_slots')->get();

        $array['category']    = $category;
        $array['warehouse'] = $warehouse;
        $array['slot']       = $slot;

        return response()->json($array);
    }

    public function printQRCode(Request $request, $id)
    {
        //   $cekOrder = DB::table('tbl_orders')->where('id_order', $id)->first();
        //   if ($cekOrder->order_category == 'penyimpanan') {
        //      $item = DB::table('tbl_orders_data')
        //         ->join('tbl_items', 'id_item', 'item_id')
        //         ->join('tbl_slots', 'id_slot', 'slot_id')
        //         ->join('tbl_warehouses', 'id_warehouse', 'warehouse_id')
        //         ->join('tbl_orders', 'tbl_orders.id_order', 'tbl_items.order_id')
        //         ->join('tbl_workunits', 'id_workunit', 'workunit_id')
        //         ->orderBy('slot_id', 'ASC')
        //         ->where('id_order', $id)
        //         ->get();
        //   } elseif ($cekOrder->order_category == 'pengeluaran') {
        //      $item = DB::table('tbl_orders_data')
        //         ->join('tbl_items', 'id_item', 'item_id')
        //         ->join('tbl_slots', 'id_slot', 'slot_id')
        //         ->join('tbl_warehouses', 'id_warehouse', 'warehouse_id')
        //         ->join('tbl_orders', 'tbl_orders.id_order', 'tbl_items.order_id')
        //         ->join('tbl_workunits', 'id_workunit', 'workunit_id')
        //         ->where('id_order', $id)
        //         ->get();
        //   }
        $qty  = $request->qty;
        $item = DB::table('tbl_orders_data')
            ->join('tbl_items', 'id_item', 'item_id')
            ->join('tbl_slots', 'id_slot', 'slot_id')
            ->join('tbl_warehouses', 'id_warehouse', 'warehouse_id')
            ->join('tbl_orders', 'tbl_orders.id_order', 'tbl_items.order_id')
            ->join('tbl_workunits', 'id_workunit', 'workunit_id')
            ->orderBy('slot_id', 'ASC')
            ->where('id_item', $id)
            ->where('slot_id', $request->slotid)
            ->get();

        return view('v_petugas.print_qrcode', compact('item', 'qty'));
    }

    public function getItem(Request $request, $id)
    {
        if ($request->proses == 'satker' && $id == 'penyimpanan') {
            $result = DB::table('tbl_warrents_entry')
                ->select('warr_item_qty as item_qty', 'id_warr_entry as id_item', 'warr_item_name as item_name', 'warr_item_unit as item_unit')
                ->join('tbl_warrents', 'id_warrent', 'warrent_id')
                ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                ->where('id_warr_entry', $request->itemId)
                ->get();
        } elseif ($request->proses == 'petugas' && $id == 'penyimpanan') {
            $result = DB::table('tbl_items')
                ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                ->join('tbl_orders', 'id_order', 'order_id')
                ->where('id_item', $request->itemId)
                ->get();
        }

        return response()->json($result);
    }

    public function getWarehouse(Request $request, $id)
    {
        $result = DB::table('tbl_slots')
            ->join('tbl_warehouses', 'id_warehouse', 'warehouse_id')
            ->where('warehouse_id', $request->warehouseId)
            ->where('slot_status', '!=', 'penuh')
            ->get();

        return response()->json($result);
    }
}
