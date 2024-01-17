<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product\Category;
use Illuminate\Foundation\Http\FormRequest;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CategoryStoreRequest extends FormRequest
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
            'category_name' => 'required',
            'category_image' => 'mimes:png,jpg,jpeg|max:2000',
        ];
    }

    public function store(){
        if($this->category_image){
            $files = $this->category_image;
            $file = $this->parent_category_name.time().'.'.$files->getClientOriginalExtension();
            $file_name = 'admin/inventory/file/category/'.$file;
            $manager = new ImageManager(new Driver);
            $manager->read($this->category_image)->resize(50,50)->save('admin/inventory/file/category/'.$file);
        }else{
            $file_name = "";
        }

        $category = new Category();
        $category->parent_category_id = $this->parent_category;
        $category->category_name = $this->category_name;
        $category->category_image = $file_name;
        $category->category_added_by = LoggedAdmin()->id;
        $category->category_status = 1;
        $category->save();

        return $category->id;
    }
}
