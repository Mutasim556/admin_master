<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\UnitStorerequest;
use App\Models\Admin\Product\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::all();
        return view('backend.blade.product.unit.index',compact('units'));
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
    public function store(UnitStorerequest $data) :Response
    {
       return response([
        'unit' => $data->store(),
        'title'=>__('admin_local.Congratulations !'),
        'text'=>__('admin_local.Unit create successfully.'),
        'confirmButtonText'=>__('admin_local.Ok'),
        'hasAnyPermission' => hasPermission(['unit-update','unit-delete']),
        'hasEditPermission' => hasPermission(['unit-update']),
        'hasDeletePermission' => hasPermission(['unit-delete']),
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
    public function edit(string $id) : Response
    {
        $unit = Unit::findOrFail($id);
        return response($unit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $data, string $id):Response
    {
        if(!request()->ajax()){
            return false;
        }
        $data->validate([
            'unit_name'=>['required','max:30','unique:units,unit_name,'.$id.',id'],
            'unit_code'=>['required','max:30','unique:units,unit_code,'.$id.',id'],
            'operator'=>['required_unless:base_unit,!=,null','max:30'],
            'operation_value'=>['required_unless:base_unit,!=,null','max:30'],
        ]);
        $unit = Unit::findOrFail($id);
        $unit->unit_name=$data->unit_name;
        $unit->unit_code=$data->unit_code;
        $unit->base_unit=$data->base_unit;
        $unit->operator=$data->operator?$data->operator:null;
        $unit->operation_value=$data->operation_value?$data->operation_value:1;
        $unit->save();

        return response([
            'unit' => $unit,
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Unit updated successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Unit::where('id',$id)->delete();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Unit deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }


    public function updateStatus(Request $data) :Response{
        Unit::where('id',$data->id)->update(['unit_status'=>$data->status,'updated_at'=>Carbon::now()]);
        $unit = Unit::where('id',$data->id)->first();
        return response($unit);
    }
}
