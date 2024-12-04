<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetArticlesRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'keyword' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:categories,id',
            'source_ids' => 'nullable|array',
            'source_ids.*' => 'integer|exists:sources,id',
            'author_ids' => 'nullable|array',
            'author_ids.*' => 'integer|exists:authors,id',
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();
        throw new HttpResponseException(errorResponse("Validation failed", $errors, 422));
    }
}
