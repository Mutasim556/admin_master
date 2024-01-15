<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BrandStoreRequest extends FormRequest
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
            'brand_name' => ['required','unique:brands,brand_name'],
            'brand_image' => 'mimes:png,jpg,jpeg|max:2000',
        ];
    }

    public function store(){
        if($this->brand_image){
            $files = $this->brand_image;
            $file = $this->brand_name.time().'.'.$files->getClientOriginalExtension();
            $file_name = 'admin/inventory/file/brand/'.$file;
            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->brand_image);
            $image = $image->resize(100,50)->save('admin/inventory/file/brand/'.$file);
            // Image::make($this->brand_image)->resize(100,50)->save('inventory/file/brand/'.$file);
        }else{
            $file_name = "";
        }

       $brand = new Brand();
       $brand->brand_name = $this->brand_name;
       $brand->brand_image = $file_name;
       $brand->brand_create_by = LoggedAdmin()->id;
       $brand->save();

       return $brand;
    }
}
