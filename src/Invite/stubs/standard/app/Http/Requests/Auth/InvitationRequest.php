<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\Invite;
use App\Models\Project;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class InvitationRequest extends FormRequest
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
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class.'|unique:'.Invite::class,
        ];
    }

        /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {

        $user = User::where('email', $this->input('email'))->first();

        //If User Already exists
        if ($user) {

            // Use this to return a success instead of fail
            // $response = $this->redirector->to($this->getRedirectUrl());
            // throw new ValidationException($validator, $response);
        }

        // If the email doesn't belong to an existing user, throw the validation exception.
        throw new ValidationException($validator);
    }
}
