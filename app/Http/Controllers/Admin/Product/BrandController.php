<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\BrandStoreRequest;
use App\Models\Admin\Product\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:brand-index,admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function store(BrandStoreRequest $data)
    {
        return $data->store();
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
}
