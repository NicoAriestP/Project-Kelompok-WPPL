<?php

namespace App\Http\Requests\User;

use App\Enum\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class EditUserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return ! Auth::guest();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = (int) $this->segment(3);

        return [
            'name' => 'nullable|string|max:255',
            'phone' => 'required|numeric|max_digits:16|min_digits:10|unique:users,phone,'.$id,
            'email' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
        ];
    }
}
