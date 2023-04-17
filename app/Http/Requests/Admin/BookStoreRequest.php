<?php

namespace App\Http\Requests\Admin;

use App\Rules\ISBN;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookStoreRequest extends FormRequest
{
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
            'publication_year' => ['required','date', 'before:today'],
            'pages'     => ['required', 'numeric', 'min:0'],
            'price'     => ['required', 'numeric', 'min:0'],
            'isbn'      => ['required', 'string', Rule::unique('books', 'isbn')->whereNull('deleted_at'), new ISBN()],
            'copies'    => ['required','numeric', 'min:0', 'max:100'],
            'is_highlighted' => ['nullable', 'boolean'],
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
            'description' => __('Pershkrimi'),
            'cover_image_url'  => __('Imazhi i Kopertines'),
            'publication_year' => __('Publication Year'),
            'pages'     => __('Faqet'),
            'price'     => __('Çmimi'),
            'isbn'      => __('ISBN'),
            'copies'    => __('Kopjet'),
            'is_highlighted'    => __('Eshte i Zgjedhur'),
            'categories'    => __('Kateorite'),
            'categories.*'    => __('Kateorite'),
        ];
    }
}
