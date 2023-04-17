<?php

namespace App\Http\Requests\Admin;

use App\Rules\ISBN;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title'       => ['required','string','min:3','max:191'],
            'author'      => ['required','string','min:3','max:191'],
            'publisher'   => ['required','string','min:3','max:191'],
            'description' => ['required','string','min:10','max:10000'],
            'cover_image_url'  => ['nullable','mimes:jpg,png,jpeg,gif,svg','max:2048'],
            'publication_year' => ['required', 'date', 'before:today'],
            'pages'     => ['required', 'numeric', 'min:0'],
            'price'     => ['required', 'numeric', 'min:0'],
            'isbn'      => ['required', 'string', Rule::unique('books', 'isbn')->whereNull('deleted_at')->ignoreModel($this->book), new ISBN()],
            'copies'    => ['required','numeric', 'min:0', 'max:100'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'numeric', 'exists:categories,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'     => __('Titulli'),
            'author'    => __('Autori'),
            'publisher' => __('Publikuesi'),
            'cover_image_url' => __('Cover Image'),
            'description' => __('Pershkrimi'),
            'pages'     => __('Faqet'),
            'price'     => __('Çmimi'),
            'isbn'      => __('ISBN'),
            'copies'    => __('Kopjet'),
            'categories'    => __('Kateorite'),
            'categories.*'    => __('Kateorite'),
        ];
    }
}
