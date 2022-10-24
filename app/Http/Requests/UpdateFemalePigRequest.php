<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\FemalePig;
use Illuminate\Http\Request;

class UpdateFemalePigRequest extends FormRequest
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
            'individual_num' => 'required|string|max:20',
            'add_day' => 'required|date|before_or_equal:today',
        ];
    }
}
