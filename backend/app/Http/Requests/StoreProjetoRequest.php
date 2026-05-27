<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjetoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'min:3', 'max:100'],
            'descricao' => ['required', 'string', 'min:10', 'max:5000'],
            'status' => ['required', 'in:rascunho,publico,privado'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'tags' => ['nullable', 'array', 'max:5'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'midias' => ['nullable', 'array', 'max:5'],
            'midias.*' => ['url', 'max:500'],
            'midia_tipos' => ['nullable', 'array'],
            'midia_tipos.*' => ['in:link,imagem,video,audio'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.min' => 'O título precisa ter pelo menos :min caracteres.',
            'titulo.max' => 'O título pode ter no máximo :max caracteres.',
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.min' => 'Descreva melhor seu projeto — pelo menos :min caracteres.',
            'descricao.max' => 'A descrição pode ter no máximo :max caracteres.',
            'status.required' => 'Escolha o status do projeto.',
            'status.in' => 'Status inválido. Use: rascunho, público ou privado.',
            'categoria_id.required' => 'Selecione a área do projeto.',
            'categoria_id.exists' => 'Categoria inválida. Escolha uma da lista.',
            'tags.max' => 'Selecione no máximo :max tags.',
            'tags.*.exists' => 'Uma das tags selecionadas é inválida.',
            'midias.max' => 'Adicione no máximo :max mídias.',
            'midias.*.url' => 'Cada mídia precisa ser uma URL válida (comece com https://).',
            'midias.*.max' => 'URL muito longa — máximo de :max caracteres.',
            'midia_tipos.*.in' => 'Tipo de mídia inválido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'titulo' => 'título',
            'descricao' => 'descrição',
            'status' => 'status',
            'categoria_id' => 'categoria',
            'tags' => 'tags',
            'midias' => 'mídias',
            'midia_tipos' => 'tipos de mídia',
        ];
    }
}
