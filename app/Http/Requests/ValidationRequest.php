<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email', //if the field is required need to put "required" value at the first

            'address' => 'nullable|string', //if the field is not required need to put "nullable value at the first

            'name' => 'required|string|max:50', //lenght of value we can use "max" or "min"

            'age' => ['nullable', 'int'], //we can even write our validation into array
        ];
    }
}
