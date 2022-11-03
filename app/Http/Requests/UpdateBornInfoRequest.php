<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBornInfoRequest extends FormRequest
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
            'mix_day'  => 'required|date|before_or_equal:today',
            'born_day' => 'required|date|before_or_equal:today|after:mix_day',
            'born_num' => 'required|integer|min:1|max:20',
        ];
    }
}
