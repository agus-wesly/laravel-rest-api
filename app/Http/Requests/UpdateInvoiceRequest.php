<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array

    {
        if (request()->method() == 'PUT') {
            return [
                'customer_id' => ['required', 'integer'],
                'amount' => ['required', 'integer'],
                'status' => Rule::in(['B', 'P', 'V']),
                'billed_date' => ['required', 'date'],
                'paid_dated' => ['date'],
            ];
        } else {
            return [
                'customer_id' => ['sometimes', 'required', 'integer'],
                'amount' => ["sometimes", 'required', 'integer'],
                'status' => ["sometimes", 'required', Rule::in(['B', 'P', 'V'])],
                'billed_date' => ["sometimes", 'required', 'date'],
                'paid_dated' => ["sometimes", 'date'],
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'customer_id' => $this->customerId,
            'billed_date' => $this->billedDate,
            'paid_dated' => $this->paidDated,
        ]);
    }
}
