<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\BrandStoreRequest;
use App\Models\Admin\Product\Brand;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:brand-index,admin');
        $this->middleware('permission:brand-store,admin')->only('store');
        $this->middleware('permission:brand-update,admin')->only(['edit','update','updateStatus']);
        $this->middleware('permission:brand-delete,admin')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index() :View
    {
        $brands = Brand::all();
        return view('backend.blade.product.brand.index',compact('brands'));
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
    public function store(BrandStoreRequest $data): Response
    {
        return response([
            'brand' => $data->store(),
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Brand created successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['brand-update','brand-delete']),
            'hasEditPermission' => hasPermission(['brand-update']),
            'hasDeletePermission' => hasPermission(['brand-delete']),
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
        $brand = Brand::findOrFail($id);
        return response($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $data, string $id) : Response
    {
        $data->validate([
            'brand_name'=>['required','unique:brands,brand_name,'.$id.',id'],
            'brand_image'=>'mimes:jpg,jpeg,png|max:2000',
        ]);
        $brand = Brand::findOrFail($id);
        if($data->brand_image){
            $files = $data->brand_image;
            $file = $data->brand_name.time().'.'.$files->getClientOriginalExtension();
            $file_name = 'inventory/file/brand/'.$file;
            if($brand->brand_image){
                unlink($brand->brand_image);
            }
            $manager = new ImageManager(new Driver());
            $image = $manager->read($data->brand_image);
            $image = $image->resize(100,50)->save('admin/inventory/file/brand/'.$file);

            $brand->brand_name=$data->brand_name;
            $brand->brand_image=$file_name;
            $brand->updated_at=Carbon::now();
            $brand->save();
        }else{
            $brand->brand_name=$data->brand_name;
            $brand->updated_at=Carbon::now();
            $brand->save();
        }
       
        return response([
            'brand' => $brand,
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Brand updated successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : Response
    {
        $brand = Brand::findOrFail($id);
        if($brand->brand_image){
            unlink($brand->brand_image);
        }
        $brand->delete();

        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Brand deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ],200);
    }

    public function updateStatus(Request $data){
        $brand = Brand::findOrFail($data->id);
        $brand->brand_status=$data->status;
        $brand->updated_at=Carbon::now();
        $brand->save();
        return response($brand);
    }
}
