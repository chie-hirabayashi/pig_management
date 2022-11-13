<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMixInfoRequest extends FormRequest
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
            'first_male_id' => 'required|select_male',
            // 'second_male_id' => 'required|select_male|different:first_male_id',
            'second_male_id' => 'select_male|different:first_male_id',
            'mix_day' => 'required|date|before_or_equal:today',
        ];
    }
}
