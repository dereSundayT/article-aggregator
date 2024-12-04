<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserPreferenceRequest extends FormRequest
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
            "category_ids" => "required|array",
            "category_ids.*" => "required|integer|exists:categories,id",

            "author_ids" => "required|array",
            "author_ids.*" => "required|integer|exists:authors,id",

            "source_ids" => "required|array",
            "source_ids.*" => "required|integer|exists:sources,id",
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();
        throw new HttpResponseException(errorResponse("Validation failed", $errors, 422));
    }
}
