<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class AddUsersToRoleRequest extends FormRequest
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
            'users' => ['required', 'array', 'min:1', Rule::exists(User::class, 'id'), Rule::unique('user_roles', 'user_id')->where(function ($query) {
                return $query->where('role_id', $this->route('role_id'));
            })]
        ];
    }
}
