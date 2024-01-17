<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product\ParentCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CreateParentCategoryRequest extends FormRequest
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
            'parent_category_name'=>['required',Rule::unique('parent_categories')->ignore('id')->where(function($query){$query->where('parent_category_delete',0);})],
            'parent_category_image'=>'mimes:jpg,jpeg,png|max:2000',
        ];
    }

    public function store(){
        if($this->parent_category_image){
            $files = $this->parent_category_image;
            $file = $this->parent_category_name.time().'.'.$files->getClientOriginalExtension();
            $file_name = 'admin/inventory/file/parent_category/'.$file;
            $manager = new ImageManager(new Driver());
            $manager->read($this->parent_category_image)->resize(50,50)->save('admin/inventory/file/parent_category/'.$file);
        }else{
            $file_name = "";
        }

        $parent_category = new ParentCategory();
        $parent_category->parent_category_name=$this->parent_category_name;
        $parent_category->parent_category_image=$file_name;
        $parent_category->parent_category_added_by=LoggedAdmin()->id;
        $parent_category->parent_category_status=1;
        $parent_category->parent_category_delete=0;
        $parent_category->save();
        
        return $parent_category;
    }
}
