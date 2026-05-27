# Palácio Mental — Backend

API e interface web do Palácio Mental, construída com **Laravel 13** + **Breeze** (Blade) + **Tailwind CSS** + **Alpine.js** + **Livewire v3**.

---

## Requisitos

| Dependência | Versão |
|---|---|
| PHP | 8.2+ |
| Composer | 2.x |
| Node.js | 18+ |
| npm | 9+ |
| MariaDB / MySQL | 10.11+ / 8+ |

---

## Setup Rápido

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
# Configure DB_* no .env
php artisan migrate:fresh --seed
php artisan serve
```

Acesse **http://localhost:8000**

Para compilar assets em tempo real:

```bash
npm run dev
```

---

## Arquitetura

### Estrutura de Diretórios

```
app/
├── Http/
│   ├── Controllers/       ← Lógica das rotas
│   │   ├── ComentarioController.php
│   │   ├── CurtidaController.php
│   │   ├── FeedController.php
│   │   ├── PerfilController.php
│   │   ├── ProjetoController.php
│   │   └── SalvoController.php
│   └── Requests/           ← Validação de formulários
│       ├── StoreProjetoRequest.php
│       └── UpdateProjetoRequest.php
├── Models/                 ← Eloquent ORM
│   ├── Categoria.php
│   ├── Comentario.php
│   ├── Midia.php
│   ├── Projeto.php
│   ├── Tag.php
│   └── User.php
database/
├── migrations/             ← 11 migrations versionadas
└── seeders/                ← Dados demo (15 projetos, 6 users)
resources/
├── views/                  ← Blade templates
│   ├── feed/index.blade.php
│   ├── projetos/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   └── perfil/show.blade.php
└── css/app.css             ← Tailwind + classes customizadas
routes/
└── web.php                 ← Rotas públicas e autenticadas
```

### Rotas

| Método | URI | Nome | Auth |
|---|---|---|---|
| GET | `/` | feed | Não |
| GET | `/projetos` | projetos.index | Não |
| GET | `/projetos/{projeto}` | projetos.show | Não |
| GET | `/u/{username}` | perfil.show | Não |
| GET | `/projetos/create` | projetos.create | Sim |
| POST | `/projetos` | projetos.store | Sim |
| GET | `/projetos/{projeto}/edit` | projetos.edit | Sim |
| PUT | `/projetos/{projeto}` | projetos.update | Sim |
| DELETE | `/projetos/{projeto}` | projetos.destroy | Sim |
| POST | `/projetos/{projeto}/curtir` | curtidas.toggle | Sim |
| POST | `/projetos/{projeto}/salvar` | salvos.toggle | Sim |
| POST | `/projetos/{projeto}/comentarios` | comentarios.store | Sim |

### Modelos e Relacionamentos

```
User ──< Projeto >── Categoria
  │        │
  │        ├──< Comentario
  │        ├──< Midia
  │        ├──<> Tag (projeto_tag)
  │        ├──<> User (curtidas)
  │        └──<> User (salvos)
  │
  └──< Comentario
```

- `<>` = belongsToMany (N:M via pivot table)
- Curtidas e Salvos são pivot tables puras (sem model próprio — acessadas via `belongsToMany`)

---

## Design System

### Paleta de Cores

| Token | Hex | Uso |
|---|---|---|
| `palacio-verde` | `#1B5A40` | CTAs, destaques, accent |
| `palacio-roxo` | `#382554` | Títulos, nav, badges |
| `palacio-bege` | `#F4ECE3` | Background, cards |
| `palacio-laranja` | `#E8A849` | Alertas, hover |
| `palacio-escuro` | `#0F2E1F` | Texto, footer |
| `palacio-claro` | `#FAF7F2` | Inputs, fundo de página |

### Tipografia

- **Títulos:** Cinzel + Playfair Display (serif — estética greco-romana)
- **Corpo:** System default sans-serif

### Classes Utilitárias (app.css)

- `.btn-primary` — Botão verde principal
- `.btn-secondary` — Botão roxo
- `.btn-outline` — Botão outline verde
- `.card` — Card com borda bege e shadow
- `.chip` — Tag/badge bege com texto roxo
- `.chip-active` — Tag/badge roxo com texto bege

---

## Seeders

Executar com dados demo:

```bash
php artisan migrate:fresh --seed
```

Ordem de execução (DatabaseSeeder):

1. `CategoriaSeeder` — 5 categorias (Web, Mobile, IA, IoT, Games)
2. `TagSeeder` — 15 tags (php, laravel, oracle, mysql, docker, python, javascript, react, figma, arduino, unity, tensorflow, api, mvc, banco-de-dados)
3. `UserSeeder` — 6 membros da equipe
4. `ProjetoSeeder` — 15 projetos acadêmicos (11 públicos, 2 rascunhos, 1 privado)
5. `MidiaSeeder` — 1-2 mídias por projeto público
6. `ComentarioSeeder` — 2-3 comentários por projeto público
7. `CurtidaSalvoSeeder` — curtidas e salvos aleatórios

---

## Comandos Úteis

```bash
# Migrations
php artisan migrate              # Roda migrations pendentes
php artisan migrate:fresh --seed # Reseta DB e roda tudo

# Servidor
php artisan serve                # http://localhost:8000
npm run dev                      # Hot reload Tailwind/JS

# Limpar cache
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```
