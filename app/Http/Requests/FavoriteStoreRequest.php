<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FavoriteStoreRequest extends FormRequest
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
            'gif_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('favorites')->where(function ($query) {
                    return $query->where('user_id', $this->user()->id);
                }),
            ],
            'alias' => 'required|string|max:255|min:3',
        ];
    }
}
