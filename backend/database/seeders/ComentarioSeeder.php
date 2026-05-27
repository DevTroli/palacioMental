<?php

namespace Database\Seeders;

use App\Models\Comentario;
use App\Models\Projeto;
use App\Models\User;
use Illuminate\Database\Seeder;

class ComentarioSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $projetosPublicos = Projeto::where('status', 'publico')->get();

        $comentarios = [
            // Projeto 1 — Palácio Mental
            ['projeto_id' => 1, 'user_id' => 2, 'conteudo' => 'Conceito muito bom! A ideia de centralizar o projeto acadêmico além do código é diferenciada.'],
            ['projeto_id' => 1, 'user_id' => 3, 'conteudo' => 'A arquitetura MVC ficou bem clara. Como vocês lidam com o controle de acesso nos projetos privados?'],
            ['projeto_id' => 1, 'user_id' => 4, 'conteudo' => 'O frontend com Tailwind ficou limpo. Seria legal ter um modo escuro!'],

            // Projeto 2 — Estufa Arduino
            ['projeto_id' => 2, 'user_id' => 5, 'conteudo' => 'O design do dashboard está intuitivo. Os gráficos de temperatura em tempo real fazem muita diferença.'],
            ['projeto_id' => 2, 'user_id' => 6, 'conteudo' => 'Já pensou em integrar com um sistema de irrigação automática? Ficaria completo.'],

            // Projeto 3 — API Tarefas
            ['projeto_id' => 3, 'user_id' => 3, 'conteudo' => 'A documentação Swagger está ótima. Facilitou muito os testes durante a integração.'],
            ['projeto_id' => 3, 'user_id' => 5, 'conteudo' => 'Senti falta de um endpoint para filtros combinados (prioridade + data). Mas o CRUD base está sólido.'],

            // Projeto 6 — E-Commerce Livros
            ['projeto_id' => 6, 'user_id' => 1, 'conteudo' => 'Integração com gateway de pagamento funcionou perfeitamente nos testes. Boa escolha de stack.'],
            ['projeto_id' => 6, 'user_id' => 4, 'conteudo' => 'A interface mobile ficou bem responsiva. O carrinho persistente via localStorage foi esperto.'],

            // Projeto 7 — App Financeiro
            ['projeto_id' => 7, 'user_id' => 6, 'conteudo' => 'A categorização automática de gastos com regex é criativa. Funciona bem para padrões comuns.'],

            // Projeto 9 — Doenças Plantas
            ['projeto_id' => 9, 'user_id' => 1, 'conteudo' => '95% de acurácia é impressionante para o PlantVillage! Testou com dados reais do campo?'],
            ['projeto_id' => 9, 'user_id' => 2, 'conteudo' => 'A API de inferência ficou rápida. Seria útil ter um endpoint batch para processar múltiplas imagens.'],

            // Projeto 10 — Microserviços
            ['projeto_id' => 10, 'user_id' => 1, 'conteudo' => 'A comunicação via RabbitMQ estava estável nos testes de carga? Tivemos problemas com isso num projeto anterior.'],
            ['projeto_id' => 10, 'user_id' => 6, 'conteudo' => 'O Docker Compose para dev está perfeito. Subiu tudo com um comando só.'],

            // Projeto 11 — Automação ESP32
            ['projeto_id' => 11, 'user_id' => 2, 'conteudo' => 'MQTT é leve e eficiente para IoT. O dashboard React ficou bem interativo.'],
            ['projeto_id' => 11, 'user_id' => 4, 'conteudo' => 'Já pensou em adicionar rotinas automáticas? Tipo apagar luzes depois de 30 min sem movimento.'],

            // Projeto 12 — Jogo Unity
            ['projeto_id' => 12, 'user_id' => 5, 'conteudo' => 'O design visual das fases está coerente com a proposta educativa. As animações ajudam no engajamento.'],
            ['projeto_id' => 12, 'user_id' => 3, 'conteudo' => 'O sistema de progressão está bem balanceado. As fases iniciais são intuitivas sem serem óbvias.'],

            // Projeto 13 — Dashboard COVID
            ['projeto_id' => 13, 'user_id' => 6, 'conteudo' => 'Os mapas de calor com D3.js ficaram impressionantes. A performance com dados grandes é boa?'],

            // Projeto 14 — App Saúde Mental
            ['projeto_id' => 14, 'user_id' => 1, 'conteudo' => 'O flow de onboarding no Figma está muito bem pensado. A paleta de cores transmite acolhimento.'],
            ['projeto_id' => 14, 'user_id' => 4, 'conteudo' => 'Seria interessante ter uma versão web além do mobile. O protótipo já cobre bem os cenários principais.'],

            // Projeto 15 — Pipeline CI/CD
            ['projeto_id' => 15, 'user_id' => 2, 'conteudo' => 'A documentação do pipeline está clara. O deploy automático economiza muito tempo.'],
            ['projeto_id' => 15, 'user_id' => 3, 'conteudo' => 'Testes automatizados no pipeline é essencial. Que cobertura de testes vocês atingiram?'],
        ];

        foreach ($comentarios as $comentario) {
            Comentario::create($comentario);
        }
    }
}
