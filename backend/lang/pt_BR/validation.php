<?php

return [
    'accepted' => 'O campo :attribute deve ser aceito.',
    'alpha_dash' => 'O campo :attribute só pode conter letras, números, hífens e underscores.',
    'confirmed' => 'A confirmação do campo :attribute não coincide.',
    'current_password' => 'A senha atual está incorreta.',
    'email' => 'O campo :attribute deve ser um email válido.',
    'in' => 'O valor selecionado para :attribute é inválido.',
    'lowercase' => 'O campo :attribute deve conter apenas letras minúsculas.',
    'max' => [
        'numeric' => 'O campo :attribute não pode ser maior que :max.',
        'string' => 'O campo :attribute pode ter no máximo :max caracteres.',
    ],
    'min' => [
        'numeric' => 'O campo :attribute deve ser pelo menos :min.',
        'string' => 'O campo :attribute precisa ter pelo menos :min caracteres.',
    ],
    'required' => 'O campo :attribute é obrigatório.',
    'unique' => 'Esse :attribute já está em uso.',
    'url' => 'O campo :attribute deve ser uma URL válida.',
    'exists' => 'O valor selecionado para :attribute é inválido.',
    'array' => 'O campo :attribute deve ser um array.',
    'integer' => 'O campo :attribute deve ser um número inteiro.',

    'custom' => [
        'email' => [
            'email' => 'Digite um email válido (ex: seuemail@exemplo.com).',
        ],
        'password' => [
            'min' => 'A senha precisa ter pelo menos :min caracteres.',
        ],
    ],
];
