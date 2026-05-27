<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjetoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'        => ['required', 'string', 'max:200'],
            'descricao'     => ['nullable', 'string'],
            'status'        => ['required', 'in:rascunho,publico,privado'],
            'categoria_id'  => ['nullable', 'exists:categorias,id'],
            'tags'          => ['nullable', 'array'],
            'tags.*'        => ['exists:tags,id'],
        ];
    }
}
