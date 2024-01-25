<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRolesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        $new_roles = $this->input('roles');

        $developer_role = \App\Models\Role::where('name', 'developer')->first();
    
        $current_roles = \App\Models\User::find($this->route('userId'))->roles->pluck('id');
    
        if (
            in_array($developer_role->id, $new_roles) && // Adding developer role
            !$current_roles->contains($developer_role->id) && // User doesn't already have the developer role
            !auth()->user()->hasPermissionName('assign.developer')
        ) {
            return false;
        }

        if (
            !in_array($developer_role->id, $new_roles) && // Adding developer role
            $current_roles->contains($developer_role->id) && // User doesn't already have the developer role
            !auth()->user()->hasPermissionName('remove.developer')
        ) {
            return false;
        }

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
            'roles' => 'nullable|array'
        ];
    }
}
