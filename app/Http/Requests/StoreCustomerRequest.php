<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'type' => ['required', Rule::in(['I', 'B', 'i', 'b'])],
            'email' => ['required', 'email', 'unique:customers'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'postal_Code' => ['required'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'postal_code' => $this->postalCode,
        ]);
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email harus unik tod',
            'type.in' => 'Tipe input nya lebih diperhatikan yah',
        ];
    }
}
