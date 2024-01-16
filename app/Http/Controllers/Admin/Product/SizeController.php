<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SizeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:size-index,admin');
        $this->middleware('permission:size-store,admin')->only('store');
        $this->middleware('permission:size-update,admin')->only(['edit','update','updateStatus']);
        $this->middleware('permission:size-delete,admin')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::all();
        return view('backend.blade.product.size.index',compact('sizes'));
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
    public function store(Request $data) : Response
    {
        if(!request()->ajax()){
            return false;
        }
        $data->validate([
            'size_name' => ['required','unique:sizes,size_name'],
        ]);
        $size = new Size();
        $size->size_name = $data->size_name;
        $size->size_create_by = LoggedAdmin()->id;
        $size->size_status = 1;
        $size->save();
        return response([
            'size'=>$size,
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Size create successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['size-update','size-delete']),
            'hasEditPermission' => hasPermission(['size-update']),
            'hasDeletePermission' => hasPermission(['size-delete']),
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
    public function edit(string $id)
    {
        $size = Size::findOrfail($id);
        return $size;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $data, string $id)
    {
        $data->validate([
            'size_name'=>['required','unique:sizes,size_name,'.$id.',id'],
        ]);
        $size = Size::findOrFail($id);
        $size->size_name=$data->size_name;
        $size->updated_at=Carbon::now();
        $size->save();

        return response([
            'size' => $size,
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Size updated successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ],200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : Response
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Size deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ],200);
    }

    public function updateStatus(Request $data){
        $size = Size::findOrFail($data->id);
        $size->size_status=$data->status;
        $size->updated_at=Carbon::now();
        $size->save();
        return response($size);
    }
}
