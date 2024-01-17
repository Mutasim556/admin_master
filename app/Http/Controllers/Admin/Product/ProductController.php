<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product\Brand;
use App\Models\Admin\Product\Category;
use App\Models\Admin\Product\Unit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-store,admin')->only(['create','store']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $brands = Brand::where('brand_status',1)->get();
        $categories = Category::where([['category_status',1],['category_delete',0]])->get();
        $units = Unit::where([['unit_status',1]])->get();
        return view('backend.blade.product.create',compact('brands','categories','units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
}
