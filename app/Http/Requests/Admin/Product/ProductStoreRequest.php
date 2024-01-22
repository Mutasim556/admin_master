<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product\Product;
use App\Models\Admin\Product\ProductVariant;
use App\Models\Admin\Product\WarehousePrice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductStoreRequest extends FormRequest
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
            'product_type' => ['required'],
            'product_name' => ['required','max:255'],
            'product_code' => ['required','integer'],
            'barcode_symbology' => ['required'],
            'category' => ['required'],
            'product_unit' => ['required'],
            'sale_unit' => ['required'],
            'purchase_unit' => ['required'],
            'unit_size' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'cartoon_size' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'product_cost' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'product_price' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'daily_sale_objective' => ['regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'alert_quantity' => ['nullable','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'variant_option.*'=>['required_if:variant,on'],
            'variant_value.*'=>['required_if:variant,on'],
            'warehouse_name.*'=>['required_if:warehouse,on'],
            'warehouse_prices.*'=>['required_if:warehouse,on'],
            'add_combo_product' =>['required_if:product_type,combo']
        ];
    }

    public function store(){
        // Log::info($this->all());
        // die();
        if($this->product_type=='standard'){
            $product = new Product();
            $product->type=$this->product_type;
            $product->name=$this->product_name;
            $product->code=$this->product_code;
            $product->barcode_symbology=$this->barcode_symbology;
            $product->brand_id=$this->brand;
            $product->category_id=$this->category;
            $product->unit_id=$this->product_unit;
            $product->sale_unit_id=$this->product_unit;
            $product->purchase_unit_id=$this->product_unit;
            $product->unit_size=$this->unit_size;
            $product->cartoon_size=$this->cartoon_size;
            $product->cost=$this->product_cost;
            $product->price=$this->product_price;
            $product->daily_sale_objective=$this->daily_sale_objective;
            $product->daily_sale_objective=$this->daily_sale_objective;
            $product->alert_quantity=$this->alert_quantity;
            $product->tax_id=$this->product_tax;
            $product->tax_method=$this->tax_method;
            $product->featured=$this->featured?1:0;
            $product->is_embeded=$this->embedded_barcode?1:0;
            
            if($this->image){
                $images = $this->image;
                $image_names = [];
                foreach ($images as $key=>$image) {
                    $imageName = $image[$key]->getClientOriginalName();
                    $manager = new ImageManager(new Driver());
                    $manager->read($image[$key])->resize(300,300)->save('admin/inventory/file/product/'.$imageName);
                    $imageName  = 'admin/inventory/file/product/'.$imageName;
                    $image_names[] = $imageName;
                }
                $product_images = implode(",", $image_names);
            }else {
                $product_images = null;
            }
            $product->image = $product_images;
            $product->product_details = $this->product_details;
            $product->is_variant=$this->variant?1:0;
            

            $product->is_diffPrice=$this->warehouse?1:0;
            

            $product->is_batch=$this->batch_expire_date?1:0;
            $product->is_imei=$this->imei?1:0;
            $product->promotion=$this->add_promotional_price?1:0;

            if($this->add_promotional_price){
                $product->promotion_price = $this->promotional_price;
                $product->starting_date = $this->promotional_start;
                $product->last_date = $this->promotional_end;
            }

            $product->created_by = LoggedAdmin()->id;
            $product->updated_by = LoggedAdmin()->id;
            $product->variant_option = implode(',',array_slice($this->variant_option,0,floor(count($this->variant_option)/($this->image?count($this->image):1))));
            $product->variant_value = implode('|',array_slice($this->variant_value,0,floor(count($this->variant_value)/($this->image?count($this->image):1))));
            // Log::info($product);
            // die();
            $product->save();
           
            
            if($this->variant){
                foreach(array_slice($this->variant_item_code,0,floor(count($this->variant_item_code)/($this->image?count($this->image):1))) as $key => $code){
                    Log::info($code);
                    $product_variant = new ProductVariant();
                    $product_variant->product_id = $product->id;
                    $product_variant->variant_id = $key+1;
                    $product_variant->position = $key+1;
                    $product_variant->item_code = $code;
                    $product_variant->additional_cost = $this->variant_additional_cost[$key];
                    $product_variant->additional_price = $this->variant_additional_price[$key];
                    $product_variant->qty = 0;
                    $product_variant->created_by = LoggedAdmin()->id;
                    $product_variant->updated_by = LoggedAdmin()->id;
                    $product_variant->delete = 0;
                    $product_variant->save();
                }
            }

            if($this->warehouse){
               
                foreach(array_slice($this->warehouse_name,0,floor(count($this->warehouse_name)/($this->image?count($this->image):1))) as $key => $wname){
                    $product_diff_price = new WarehousePrice();
                    $product_diff_price->product_id = $product->id;
                    $product_diff_price->warehouse_id = $this->warehouse_id[$key];
                    $product_diff_price->price = $this->warehouse_prices[$key];
                    $product_diff_price->created_by = LoggedAdmin()->id;
                    $product_diff_price->updated_by = LoggedAdmin()->id;
                    $product_diff_price->delete = 0;
                    $product_diff_price->save();
                }
            }

        }
    }
}
