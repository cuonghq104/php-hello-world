<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerCreateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

        dd($this->request);
        return [
            'name' => 'required',
            'nationality' => 'required',
            'position' => 'required|in:Forward,Midfielder,Defender,Goalkeeper'
        ];
    }

    public function messages()
    {
        return [
            'position.in' => 'Position must be one of these: Forward, Midfielder, Defender, Goalkeeper'
        ];
    }
}
