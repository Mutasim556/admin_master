<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product\Unit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UnitStorerequest extends FormRequest
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
            'unit_name'=>['required','max:30',Rule::unique('units')->where(function($query){return $query->where('unit_status','Active');})],
            'unit_code'=>['required','max:30',Rule::unique('units')->where(function($query){return $query->where('unit_status','Active');})],
            'operator'=>['required_unless:base_unit,!=,null','max:30'],
            'operation_value'=>['required_unless:base_unit,!=,null','max:30'],
        ];
    }

    public function store(){
        $unit = new Unit();
        $unit->unit_name=$this->unit_name;
        $unit->unit_code=$this->unit_code;
        $unit->base_unit=$this->base_unit;
        $unit->unit_created_by=LoggedAdmin()->id;
        $unit->operator=$this->operator?$this->operator:null;
        $unit->operation_value=$this->operation_value?$this->operation_value:1;
        $unit->unit_status = 0;
        $unit->save();
        return  $unit;
    }
}
