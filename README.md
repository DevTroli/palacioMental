# 🧠 Palácio Mental

### Rede Acadêmica de Compartilhamento de Projetos

> **Imagine o GitHub, mas pensado para o projeto acadêmico em sua totalidade — não só o código, mas a ideia, o processo, a documentação e a evolução. O Palácio Mental é onde o trabalho do semestre deixa de morrer num ZIP e passa a existir.**

**Trabalho Semestral — Engenharia de Software**
**Fatec Praia Grande · Desenvolvimento de Software Multiplataforma · 1º Semestre de 2026**

---

## 👥 Equipe

| Papel | Membro |
|---|---|
| Tech Lead & DB Lead | Pablo Troli |
| Backend | Felipe Figueiredo |
| Backend | Eduardo Elias |
| Frontend Lead | Iago Sampaio |
| UI/UX Designer | Yohan Ruiz |
| DevOps & Docs | Matheus Fernandes |

**Coordenador:** Prof. Marcio Galvão

---

## 💡 Proposta de Valor

| Para quem | Dor atual | O que o Palácio Mental oferece |
|---|---|---|
| Estudante de tecnologia | Projetos ficam esquecidos após a entrega | Portfólio vivo, construído ao longo do curso |
| Estudante iniciante | Não sabe o que os colegas mais avançados estão fazendo | Feed de projetos por categoria e nível |
| Professor / orientador | Não tem visibilidade do progresso dos alunos fora da sala | Projetos públicos com histórico de atualizações |
| Recrutador / empresa | Dificuldade de encontrar talentos acadêmicos emergentes | Perfis com projetos reais, comentados pela comunidade |

---

## 🛠️ Stack Tecnológica

| Camada | Tecnologia |
|---|---|
| Banco de Dados | MariaDB 11.8 (MySQL-compatible) |
| Backend | PHP 8.4 + Laravel 13 |
| Auth | Laravel Breeze (Blade stack) |
| Frontend | Blade + Tailwind CSS + Alpine.js + Livewire v3 |
| Design | Figma |
| DevOps | Docker + GitHub Actions |

---

## 🗃️ Modelagem de Banco de Dados

### Entidades

- **USUARIO** — perfis de criadores da plataforma
- **PROJETO** — ideias e trabalhos publicados (entidade central)
- **CATEGORIA** — classificação principal dos projetos
- **TAG** — palavras-chave livres para descoberta
- **COMENTARIO** — feedback da comunidade (entidade fraca)
- **MIDIA** — arquivos e links associados aos projetos (entidade fraca)
- **CURTIDA** — interação N:M entre USUARIO e PROJETO
- **SALVO** — curadoria pessoal N:M entre USUARIO e PROJETO
- **PROJETO_TAG** — tabela associativa N:M entre PROJETO e TAG

### Diagramas e Documentação

- Modelo Conceitual: `database/docs/modelo_conceitual_palaciomental.png`
- Modelo Lógico: `database/docs/modelo_logico_palaciomentasl.png`
- Dicionário de Dados: `database/docs/dicionario_dados.md`
- DDL MySQL: `database/mysql/palacio_mental_mysql.sql`

---

## 📁 Estrutura do Repositório

```
palacioMental/
├── README.md
├── CLAUDE.md
├── Docs/
│   ├── 00_ESTRUTURA_DA_EQUIPE.md
│   ├── GUIA_GITHUB_GESTAO.md
│   ├── MILESTONE_0_PLANEJAMENTO.md
│   ├── MILESTONE_1_FUNDACAO.md
│   └── STACK_TECNOLOGICA.md
├── database/
│   ├── mysql/
│   │   └── palacio_mental_mysql.sql
│   ├── docs/
│   │   ├── dicionario_dados.md
│   │   ├── modelo_conceitual_palaciomental.png
│   │   └── modelo_logico_palaciomentasl.png
│   └── seeds/
│       └── seed_data.sql
├── backend/               ← Laravel 13
│   ├── app/
│   │   ├── Http/Controllers/
│   │   ├── Http/Requests/
│   │   ├── Models/
│   │   └── Livewire/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── resources/
│   │   ├── views/
│   │   └── css/
│   ├── routes/
│   └── README.md
└── frontend/              ← (fase futura)
```

---

## 🚀 Como Rodar Localmente

### Pré-requisitos

- PHP 8.2+
- Composer 2.x
- Node.js 18+ e npm
- MariaDB 10.11+ (ou MySQL 8+)
- Git

### 1. Clone o repositório

```bash
git clone https://github.com/DevTroli/palacioMental.git
cd palacioMental
```

### 2. Configure o banco de dados

Crie um banco e um usuário no MariaDB/MySQL:

```sql
CREATE DATABASE palacio_mental CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'palacio'@'localhost' IDENTIFIED BY 'palacio123';
GRANT ALL PRIVILEGES ON palacio_mental.* TO 'palacio'@'localhost';
FLUSH PRIVILEGES;
```

> **Arch Linux:** use `sudo mariadb` para acessar o console como root (autenticação unix_socket).

### 3. Configure o backend

```bash
cd backend
cp .env.example .env
composer install
npm install
php artisan key:generate
```

Edite o `.env` com as credenciais do banco:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=palacio_mental
DB_USERNAME=palacio
DB_PASSWORD=palacio123
```

### 4. Rode as migrations e seeders

```bash
php artisan migrate:fresh --seed
```

### 5. Inicie o servidor

```bash
php artisan serve
```

Acesse: **http://localhost:8000**

### 6. (Opcional) Compile assets em tempo real

```bash
npm run dev
```

---

## 🔧 Como Contribuir

1. Leia o `Docs/GUIA_GITHUB_GESTAO.md` antes de qualquer coisa
2. Pegue uma issue do board (GitHub Projects)
3. Crie uma branch: `feature/nome-da-feature` a partir de `develop`
4. Abra Pull Request para `develop` com pelo menos 1 aprovação
5. Nunca commite direto em `main` ou `develop`

---

**Feito com 💚 pela equipe Palácio Mental · Fatec Praia Grande · 2026**
