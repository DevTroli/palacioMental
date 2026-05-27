<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            // Tecnologia
            'Web',
            'Mobile',
            'Inteligência Artificial',
            'IoT',
            'Games',
            // Engenharias
            'Engenharia de Software',
            'Engenharia Civil',
            'Engenharia Mecânica',
            'Engenharia Elétrica',
            // Ciências Exatas
            'Ciência de Dados',
            'Matemática e Estatística',
            // Saúde
            'Saúde e Bem-estar',
            // Humanas e Sociais
            'Educação',
            'Gestão e Negócios',
            // Multidisciplinar
            'Sustentabilidade',
            'Design e UX',
        ];

        foreach ($categorias as $nome) {
            Categoria::create(['nome' => $nome]);
        }
    }
}
