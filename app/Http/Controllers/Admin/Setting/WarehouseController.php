<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\WarehouseStoreRequest;
use App\Models\Admin\Settings\Warehouse;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() :View
    {
        $warehouses = Warehouse::where('delete',0)->get();
        return view('backend.blade.settings.warehouse',compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WarehouseStoreRequest $data) :Response
    {
        return response([
            'warehouse' => $data->store(),
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Warehouse create successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['warehouse-update','warehouse-delete']),
            'hasEditPermission' => hasPermission(['warehouse-update']),
            'hasDeletePermission' => hasPermission(['warehouse-delete']),
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id):Response
    {
        $warehouse = Warehouse::findOrFail($id);
        return response($warehouse);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $data, string $id):Response
    {
        $data->validate([
            'warehouse_name'=>['required','unique:warehouses,name,'.$data->warehouse_id],
            'warehouse_phone'=>['required','unique:warehouses,phone,'.$data->warehouse_id],
            'warehouse_email'=>['unique:warehouses,email,'.$data->warehouse_id],
        ]);

        $warehouse = Warehouse::findOrFail($id);
        $warehouse->name = $data->warehouse_name;
        $warehouse->phone = $data->warehouse_phone;
        $warehouse->email = $data->warehouse_email;
        $warehouse->address = $data->warehouse_address;
        $warehouse->save();

        return response([
            'warehouse' => $warehouse,
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Warehouse updated successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) :Response
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete = 1;
        $warehouse->save();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Warehouse deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    public function updateStatus(Request $data) :Response{
        Warehouse::where('id',$data->id)->update(['status'=>$data->status,'updated_at'=>Carbon::now()]);
        $unit = Warehouse::where('id',$data->id)->first();
        return response($unit);
    }
}
