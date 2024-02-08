<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\AdjustmentStoreRequest;
use App\Models\Admin\Product\Adjustment;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Product\WarehousePrice;
use App\Models\Admin\Settings\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdjustmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:adjustment-store,admin')->only(['create','store','getWarehouseProduct','getProduct']);
        $this->middleware('permission:adjustment-index,admin')->only(['index','getAdjustmentProduct']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(isset($_GET['date_range'])){
            $date_range = explode(' - ',$_GET['date_range']);
            $startDate = Carbon::parse($date_range[0])->startOfDay();
            $endDate = Carbon::parse($date_range[1])->endOfDay();
            $adjustments = Adjustment::whereBetween('created_at',[$startDate,$endDate])->with('warehouse','admin')->get();
        }else{
            $startDate = Carbon::now()->subDays(6)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
            $adjustments = Adjustment::whereBetween('created_at',[$startDate,$endDate])->with('warehouse','admin')->get();
        }
        $startDate =  $startDate->format('m/d/Y');
        $endDate =  $endDate->format('m/d/Y');
        return view('backend.blade.product.adjustment.index',compact('adjustments','startDate','endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where([['status',1],['delete',0]])->select('name','id','price','is_variant')->get();
        $product_name = [];
        $product_prices = [];
        foreach($products as $key=>$product){
            array_push($product_name,$product->id."@".$product->name);
            $product_prices[$key]=$product->price;
        }
        $warehouses = Warehouse::where([['delete',0],['status',1]])->get();
        return view('backend.blade.product.adjustment.create',compact('product_name','product_prices','warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdjustmentStoreRequest $data)
    {
        $adjustment = $data->store();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Adjustment completed successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
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

    public function getWarehouseProduct(string $id) : Response {
        $warehouses = WarehousePrice::with('product')->where('warehouse_id',$id)->get();

        $product_name = [];
        $product_prices = [];
        $product_quantity = [];
        foreach($warehouses as $key=>$warehouse){
            array_push($product_name,$warehouse->product->id."@".$warehouse->product->name);
            $product_prices[$key]=$warehouse->product->price;
            $product_quantity[$key]=$warehouse->quantity;
        }
        return response([
            'product_name'=>$product_name,
            'product_prices'=>$product_prices,
            'product_quantity'=>$product_quantity,
        ]);
    }

    public function getProduct(string $id,string $wid=null) : Response {
        $product = Product::with('productVariant')->where('id',$id)->first();
        if($product->is_variant){
            $warehousePrice=null;
            if($wid){
                $warehousePrice = WarehousePrice::where([['product_id',$product->id],['warehouse_id',$wid]])->first();
            }
            return response(['warehouse_price'=>$warehousePrice,'variant'=>$product->productVariant,'product'=>$product]);
        }else{
            return response(['warehouse_price'=>'No','variant'=>'No','product'=>$product]);
        }
    }

    public function getAdjustmentProduct(string $id):Response{
        $adjustment = Adjustment::findOrFail($id);
        $products = [];
        $quantity_explode = explode(',',$adjustment->total_qty);
        $adjustment_action = explode(',',$adjustment->action);
        foreach(explode(',',$adjustment->product_id) as $key=>$value){
            $prod = Product::select('name','code','qty')->findOrFail($value);
            $prod->adjust_qty = $quantity_explode[$key];
            $prod->action = $adjustment_action[$key]=='-'?'Subtraction':'Addition';
            array_push($products,$prod);
        }
        return response($products);
    }
}
