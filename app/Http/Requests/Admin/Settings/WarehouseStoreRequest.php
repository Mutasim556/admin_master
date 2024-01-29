<?php

namespace App\Http\Requests\Admin\Settings;

use App\Models\Admin\Settings\Warehouse;
use Illuminate\Foundation\Http\FormRequest;

class WarehouseStoreRequest extends FormRequest
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
            'warehouse_name'=>['required','unique:warehouses,name'],
            'warehouse_phone'=>['required','unique:warehouses,phone'],
            'warehouse_email'=>['unique:warehouses,email'],
        ];
    }

    public function store(){
        $warehouse = new Warehouse();
        $warehouse->name = $this->warehouse_name;
        $warehouse->phone = $this->warehouse_phone;
        $warehouse->email = $this->warehouse_email;
        $warehouse->address = $this->warehouse_address;
        $warehouse->status = 1;
        $warehouse->delete = 0;
        $warehouse->created_by = LoggedAdmin()->id;
        $warehouse->save();

        return $warehouse;
    }
}
