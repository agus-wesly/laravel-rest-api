<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
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
            '*.customer_id' => ['required', 'integer'],
            '*.amount' => ['required', 'integer'],
            '*.status' => Rule::in(['B', 'P', 'V']),
            '*.billed_date' => ['required', 'date'],
            '*.paid_dated' => ['date'],
        ];
    }

    protected function prepareForValidation()
    {
        $arr = [];
        foreach ($this->toArray() as $field) {
            $field['customer_id'] = $field['customerId'];
            $field['billed_date'] = $field['billedDate'];
            $field['paid_dated'] = $field['paidDated'];

            $arr[] = $field;
        }
        $this->merge($arr);
    }

    protected function passedValidation()
    {
        $data = collect($this->toArray())->map(function ($item) {
            return Arr::except($item, ['customerId', 'billedDate', 'paidDated']);
        })->toArray();

        $this->merge($data);
    }
}
