<?php

namespace Database\Seeders;

use App\Models\Projeto;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjetoSeeder extends Seeder
{
    public function run(): void
    {
        $troli    = User::where('username', 'troli')->first();
        $felipe   = User::where('username', 'felipe')->first();
        $eduardo  = User::where('username', 'eduardo')->first();
        $iago     = User::where('username', 'iago')->first();
        $yohan    = User::where('username', 'yohan')->first();
        $matheus  = User::where('username', 'matheus')->first();

        $projetos = [
            // Troli (5 projetos)
            [
                'user_id' => $troli->id,
                'categoria_id' => 1, // Web
                'titulo' => 'Palácio Mental — Plataforma de Compartilhamento Acadêmico',
                'descricao' => 'Plataforma inspirada no GitHub voltada para projetos acadêmicos. Permite que estudantes compartilhem não só o código, mas a ideia, o processo, a documentação e a evolução do trabalho. Stack: Laravel, MySQL, Tailwind CSS.',
                'status' => 'publico',
                'tags' => [1, 2, 4, 13, 14], // php, laravel, mysql, api, mvc
            ],
            [
                'user_id' => $troli->id,
                'categoria_id' => 4, // IoT
                'titulo' => 'Monitoramento de Estufa com Arduino e Sensores',
                'descricao' => 'Sistema de monitoramento em tempo real de estufas agrícolas utilizando Arduino, sensores de temperatura e umidade, com dashboard web para visualização dos dados. Trabalho de conclusão da disciplina de Sistemas Embarcados.',
                'status' => 'publico',
                'tags' => [10, 6, 4], // arduino, python, mysql
            ],
            [
                'user_id' => $troli->id,
                'categoria_id' => 1, // Web
                'titulo' => 'API RESTful para Gestão de Tarefas',
                'descricao' => 'API REST completa com autenticação JWT, CRUD de tarefas, filtros por prioridade e data, documentação Swagger. Projeto da disciplina de Desenvolvimento Web II.',
                'status' => 'publico',
                'tags' => [1, 2, 13, 14], // php, laravel, api, mvc
            ],
            [
                'user_id' => $troli->id,
                'categoria_id' => 3, // IA
                'titulo' => 'Classificador de Sentimentos em Reviews com TensorFlow',
                'descricao' => 'Modelo de NLP para classificação de sentimentos em reviews de produtos. Utiliza LSTM e word embeddings. Acurácia de 89% no dataset de teste.',
                'status' => 'rascunho',
                'tags' => [6, 12], // python, tensorflow
            ],
            [
                'user_id' => $troli->id,
                'categoria_id' => 1, // Web
                'titulo' => 'Migração Oracle → MySQL: Lições Aprendidas',
                'descricao' => 'Documentação técnica da migração de um schema Oracle para MySQL, incluindo adaptação de sequences para AUTO_INCREMENT, triggers, e tipos de dados. Relatório da disciplina de Banco de Dados II.',
                'status' => 'privado',
                'tags' => [3, 4, 15], // oracle, mysql, banco-de-dados
            ],

            // Felipe (3 projetos)
            [
                'user_id' => $felipe->id,
                'categoria_id' => 1, // Web
                'titulo' => 'E-Commerce de Livros com Laravel e Vue.js',
                'descricao' => 'Loja virtual completa com carrinho, checkout, painel admin e integração com gateway de pagamento. Desenvolvido como projeto integrador das disciplinas de Web e Banco de Dados.',
                'status' => 'publico',
                'tags' => [1, 2, 7, 8, 4], // php, laravel, javascript, react, mysql
            ],
            [
                'user_id' => $felipe->id,
                'categoria_id' => 2, // Mobile
                'titulo' => 'App de Controle Financeiro Pessoal com React Native',
                'descricao' => 'Aplicativo mobile para controle de gastos com gráficos mensais, categorização automática e notificações de limite. Projeto da disciplina de Desenvolvimento Mobile.',
                'status' => 'publico',
                'tags' => [7, 8, 13], // javascript, react, api
            ],
            [
                'user_id' => $felipe->id,
                'categoria_id' => 1, // Web
                'titulo' => 'Sistema de Agendamento Médico Online',
                'descricao' => 'Plataforma web para agendamento de consultas com notificação por e-mail, prontuário eletrônico simplificado e controle de disponibilidade por médico.',
                'status' => 'rascunho',
                'tags' => [1, 2, 4, 14], // php, laravel, mysql, mvc
            ],

            // Eduardo (3 projetos)
            [
                'user_id' => $eduardo->id,
                'categoria_id' => 3, // IA
                'titulo' => 'Detecção de Doenças em Plantas com Visão Computacional',
                'descricao' => 'Modelo de deep learning para identificação de doenças em folhas de tomateiro usando CNN. Dataset PlantVillage com 95% de acurácia. Projeto de Inteligência Artificial.',
                'status' => 'publico',
                'tags' => [6, 12, 13], // python, tensorflow, api
            ],
            [
                'user_id' => $eduardo->id,
                'categoria_id' => 1, // Web
                'titulo' => 'Microserviços com Docker: Orquestração de Serviços',
                'descricao' => 'Arquitetura de microserviços com API Gateway, service discovery e comunicação via RabbitMQ. Cada serviço roda em container Docker independente.',
                'status' => 'publico',
                'tags' => [5, 6, 13], // docker, python, api
            ],
            [
                'user_id' => $eduardo->id,
                'categoria_id' => 4, // IoT
                'titulo' => 'Automação Residencial com ESP32 e MQTT',
                'descricao' => 'Sistema IoT para controle de luzes e tomadas via protocolo MQTT com dashboard React para monitoramento em tempo real.',
                'status' => 'publico',
                'tags' => [10, 7, 8], // arduino, javascript, react
            ],

            // Iago (2 projetos)
            [
                'user_id' => $iago->id,
                'categoria_id' => 5, // Games
                'titulo' => 'Jogo Educativo de Lógica com Unity',
                'descricao' => 'Game 2D de quebra-cabeças lógicos desenvolvido na Unity com C#. O jogador progride por fases que ensinam conceitos de lógica de programação de forma lúdica.',
                'status' => 'publico',
                'tags' => [11, 7], // unity, javascript
            ],
            [
                'user_id' => $iago->id,
                'categoria_id' => 1, // Web
                'titulo' => 'Dashboard Interativo de Dados COVID com React e D3.js',
                'descricao' => 'Visualização interativa de dados epidemiológicos com gráficos dinâmicos, filtros por região e período, e mapas de calor. Projeto da disciplina de Visualização de Dados.',
                'status' => 'publico',
                'tags' => [7, 8, 13], // javascript, react, api
            ],

            // Yohan (1 projeto)
            [
                'user_id' => $yohan->id,
                'categoria_id' => 2, // Mobile
                'titulo' => 'Protótipo de App de Saúde Mental com Figma',
                'descricao' => 'Design completo de aplicativo de apoio à saúde mental: tracking de humor, exercícios de mindfulness e chat com voluntários. Entregável da disciplina de UX Design.',
                'status' => 'publico',
                'tags' => [9, 8], // figma, react
            ],

            // Matheus (1 projeto)
            [
                'user_id' => $matheus->id,
                'categoria_id' => 1, // Web
                'titulo' => 'Pipeline CI/CD com GitHub Actions para Laravel',
                'descricao' => 'Configuração completa de pipeline de integração e entrega contínua: lint, testes automatizados, build de imagem Docker e deploy automático em VPS. Documentação da disciplina de DevOps.',
                'status' => 'publico',
                'tags' => [5, 1, 2], // docker, php, laravel
            ],
        ];

        foreach ($projetos as $projData) {
            $tags = $projData['tags'];
            unset($projData['tags']);

            $projeto = Projeto::create($projData);
            $projeto->tags()->sync($tags);
        }
    }
}
