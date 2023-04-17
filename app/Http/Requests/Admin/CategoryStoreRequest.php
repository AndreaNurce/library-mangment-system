<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required','string','min:3','max:20'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => __('Titulli'),
        ];
    }
}
