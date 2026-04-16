<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan user punya hak akses jika diperlukan
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'status'      => ['required', 'in:0,1,true,false'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Handle respon saat validasi update gagal
     */
    protected function failedValidation(Validator $validator)
    {
        // Respon untuk AJAX/Fetch (Alpine.js)
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Update gagal, periksa kembali input Anda.',
                'errors'  => $validator->errors()
            ], 422));
        }

        // Respon untuk Form HTML biasa
        throw new HttpResponseException(
            redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'Gagal memperbarui produk. Silakan cek detail error di bawah.')
        );
    }

    /**
     * Custom nama field untuk pesan error
     */
    public function attributes(): array
    {
        return [
            'name'        => 'Nama Produk',
            'price'       => 'Harga Produk',
            'status'      => 'Status Aktif',
            'description' => 'Deskripsi Produk',
        ];
    }

    /**
     * Custom pesan error
     */
    public function messages(): array
    {
        return [
            'price.max' => 'Harga yang Anda masukkan terlalu besar untuk sistem.',
            'status.required' => 'Status produk harus dipilih.',
        ];
    }
}
