<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreChatRequest extends FormRequest
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

        //for checking user get class of user model
        $userModel = get_class(new User());

        return [

            //in validate check for existsting that user that we checking for
            'user_id' => "required|exists:{$userModel}, id",
            'name' => 'nullable',
            'is_private' => 'nullable|boolean'
        ];
    }
}
