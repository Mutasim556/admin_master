<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductStoreRequest;
use App\Models\Admin\Product\Brand;
use App\Models\Admin\Product\Category;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Product\Unit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    public function __construct()
    {
       
        $this->middleware('permission:product-store,admin')->only(['create','store']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index() :View
    {
        $products = Product::with('productVariant','warehousePrice','brand','category')->where('delete',0)->get();
        return view('backend.blade.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $brands = Brand::where('brand_status',1)->get();
        $categories = Category::where([['category_status',1],['category_delete',0]])->get();
        $units = Unit::where([['unit_status',1]])->get();
        $products = Product::where([['status',1],['delete',0]])->select('name','id','price','is_variant')->get();
        $product_name = [];
        $product_prices = [];
        foreach($products as $key=>$product){
            array_push($product_name,$product->id."@".$product->name);
            $product_prices[$key]=$product->price;
        }


        // dd(implode(',',$product_prices));
        return view('backend.blade.product.create',compact('brands','categories','units','product_name','product_prices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $data) : Response
    {
        if($data->store()){
            return  response([
                'title'=>__('admin_local.Congratulations !'),
                'text'=>__('admin_local.Product added successfully.'),
                'confirmButtonText'=>__('admin_local.Ok'),
            ],200);
        }else{
            return  response([
                'title'=>__('admin_local.Warning !'),
                'text'=>__('admin_local.Server Error'),
                'confirmButtonText'=>__('admin_local.Ok'),
            ],403);;
        }
       
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    //custom method
    public function generateProductCode(Request $data) : Response
    {
        $random = "";
        srand((float) microtime() * 1000000);
        $data = "123456123456789071234567890890";
        for ($i = 0; $i < 8; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        return response($random);
    }

    public function getUnit(Request $data) :Response
    {
        $unit = Unit::where('id', $data->pram)->orWhere('unit_name', 'LIKE', '%' . $data->pram . '%')->select('id', 'unit_name')->first();
        return response($unit);
    }

    public function getVariant(Request $data) :Response
    {
        $product = Product::with('productVariant')->where('id',$data->pram)->first();
        if($product->is_variant){
            return response(['variant'=>$product->productVariant,'product'=>$product]);
        }else{
            return response(['variant'=>'No','product'=>$product]);
        }
        
    }

    
}
