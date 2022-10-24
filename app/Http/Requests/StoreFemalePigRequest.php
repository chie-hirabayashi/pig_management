<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFemalePigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'individual_num' => 'required|string|max:20|unique:female_pigs,individual_num,NULL,exist,exist,1',
            'add_day'        => 'required|date|before_or_equal:today',
        ];
    }
}
