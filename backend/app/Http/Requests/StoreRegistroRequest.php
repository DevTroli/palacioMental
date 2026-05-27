<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreRegistroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'max:30', 'alpha_dash:ascii', Rule::unique(User::class)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome precisa ter pelo menos :min caracteres.',
            'name.max' => 'O nome pode ter no máximo :max caracteres.',

            'username.required' => 'O username é obrigatório.',
            'username.min' => 'O username precisa ter pelo menos :min caracteres.',
            'username.max' => 'O username pode ter no máximo :max caracteres.',
            'username.alpha_dash' => 'O username só pode conter letras, números, hífens e underscores. Sem espaços ou acentos.',
            'username.unique' => 'Esse username já está em uso. Tente outro.',

            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Digite um email válido (ex: seuemail@exemplo.com).',
            'email.lowercase' => 'Use apenas letras minúsculas no email.',
            'email.max' => 'O email pode ter no máximo :max caracteres.',
            'email.unique' => 'Esse email já está cadastrado. Faça login ou use outro email.',

            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'As senhas não coincidem. Digite a mesma senha nos dois campos.',
            'password.min' => 'A senha precisa ter pelo menos :min caracteres.',
            'password.mixed' => 'A senha precisa ter pelo menos uma letra maiúscula e uma minúscula.',
            'password.symbols' => 'A senha precisa ter pelo menos um caractere especial (ex: !@#$%).',
            'password.numbers' => 'A senha precisa ter pelo menos um número.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'username' => 'username',
            'email' => 'email',
            'password' => 'senha',
            'password_confirmation' => 'confirmar senha',
        ];
    }
}
