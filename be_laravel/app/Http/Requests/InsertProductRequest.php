<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class InsertProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Pastikan ini true jika tidak pakai logic permission khusus
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // Saya tambahkan max agar tidak error 'numeric value out of range' lagi
            'price' => ['required', 'numeric', 'min:0', 'max:2147483647'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom Response saat validasi gagal
     */
    protected function failedValidation(Validator $validator)
    {
        // Jika request datang dari AJAX atau mengharapkan JSON
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Validasi gagal bro!',
                'errors'  => $validator->errors()
            ], 422));
        }

        // Jika request biasa (web form), kita kembalikan dengan pesan error session
        throw new HttpResponseException(
            redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'Input tidak boleh kosong')
        );
    }

    /**
     * Opsional: Custom nama atribut agar pesan error lebih rapi
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Produk',
            'price' => 'Harga Produk',
            'description' => 'Deskripsi',
        ];
    }
}
