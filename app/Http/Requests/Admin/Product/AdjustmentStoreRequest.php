<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product\Adjustment;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Product\WarehousePrice;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class AdjustmentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'warehouse'=>'required',
            'attatched_file'=>['mimes:png,jpg,pdf,docs','max:2000'],
            'product_id'=>'required',
            'product_id.*'=>'required',
            'product_quantity'=>'required',
            'product_quantity.*'=>'required',
            'action'=>'required',
            'action.*'=>'required',
        ];
    }

    public function store(){
        $adjustment = new Adjustment();
        $adjustment->reference_no = $this->referance?$this->referance:'adj-'.time();
        $adjustment->warehouse_id = $this->warehouse;
        
        $adjustment->total_qty = implode(',',$this->product_quantity);
        $adjustment->product_id = implode(',',$this->product_id);
        $adjustment->note = $this->notes;
        $adjustment->action = implode(',',$this->action);
        $adjustment->created_by = LoggedAdmin()->id;
        $adjustment->updated_by = LoggedAdmin()->id;
        if($this->attatched_file){
            $file = $this->attatched_file;
            $fileName = "ADJUSTMENT_FILE".time().'.'.$file->getClientOriginalExtension();
            $this->attatched_file->move('admin/inventory/file/adjustment/',$fileName);
            $adjustment->document = 'admin/inventory/file/product/file/'.$fileName;
        }else{
            $adjustment->document = null;
        }
        $adjustment->save();
        foreach($this->product_id as $key=>$value){
            $product = Product::findOrFail($value);
            $warehouse_price = WarehousePrice::where([['product_id',$product->id],['warehouse_id',$this->warehouse]])->first();
            if($this->action[$key]=='-'){
                $warehouse_price->quantity -= $this->product_quantity[$key];
                $product->qty -= $this->product_quantity[$key];
            }else{
                $warehouse_price->quantity += $this->product_quantity[$key];
                $product->qty += $this->product_quantity[$key];
            }
            $product->updated_by = LoggedAdmin()->id;
            $product->updated_at = Carbon::now();
            $warehouse_price->updated_by = LoggedAdmin()->id;
            $warehouse_price->updated_at = Carbon::now();
            $product->save();
            $warehouse_price->save();
            
        }
        return 1;
    }
}
