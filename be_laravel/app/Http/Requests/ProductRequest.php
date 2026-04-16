<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search'     => ['nullable', 'string', 'max:100'],
            'name'       => ['nullable', 'string', 'max:255'],
            'description'=> ['nullable', 'string'],
            'price'      => ['nullable', 'numeric', 'min:0', 'max:2147483647'],
            'status'     => ['nullable', 'in:0,1,true,false'], // Lebih aman untuk input select/boolean
            'pagination' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    /**
     * Handle respon jika filter yang dimasukkan tidak valid
     */
    protected function failedValidation(Validator $validator)
    {
        // Jika request via AJAX (misal search real-time dengan Alpine/Axios)
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'message' => 'Filter tidak valid',
                'errors' => $validator->errors()
            ], 422));
        }

        // Untuk request halaman biasa
        throw new HttpResponseException(
            redirect()->back()
                ->withInput()
                ->with('error', 'Format pencarian atau filter tidak sesuai.')
                ->withErrors($validator)
        );
    }

    /**
     * Custom pesan error agar user paham apa yang salah
     */
    public function messages(): array
    {
        return [
            'price.numeric' => 'Harga harus berupa angka.',
            'price.max'     => 'Nilai harga melampaui batas sistem.',
            'pagination.integer' => 'Jumlah halaman harus berupa angka bulat.',
        ];
    }
}
