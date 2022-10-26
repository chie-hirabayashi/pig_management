<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMixInfoRequest extends FormRequest
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
            'male_first_id'  => 'required|select_male',
            'male_second_id' => 'required|select_male|different:male_first_id',
            'mix_day'        => 'required|date|before_or_equal:today',
        ];
    }
}
