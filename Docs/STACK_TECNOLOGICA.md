# Stack Tecnológica — Palácio Mental

## Visão Geral

Plataforma web de compartilhamento de projetos universitários, desenvolvida como Projeto Integrador da Fatec Praia Grande (DSM 2026).

## Stack de Execução

| Camada | Tecnologia | Versão |
|---|---|---|
| Backend | Laravel | 12 |
| Banco de Dados | MySQL | 8 |
| Frontend (SSR) | Blade | (nativo do Laravel) |
| Frontend (interativo) | Livewire | 3 |
| Estilização | Tailwind CSS | 4 |

## Justificativa

### Laravel 12

Framework PHP maduro que provê: ORM (Eloquent), migrations, autenticação, rotas, middleware e scaffolding de admin prontos para uso. Reduz código boilerplate e garante convenções de projeto que facilitam manutenção e onboarding.

### MySQL 8

SGBD relacional compatível com o modelo de dados Oracle desenvolvido na disciplina. O schema MySQL replica fielmente as tabelas, constraints e relações do modelo lógico Oracle. Motivos para MySQL no ambiente de execução:

- Driver nativo no Laravel (sem configuração manual de Instant Client)
- Docker oficial leve para demo
- Compatibilidade total com Eloquent ORM

> **Nota acadêmica:** O schema Oracle original está documentado em `database/` com DDL, migrations versionadas, PL/SQL e diagramas ER. MySQL é a implementação física consumida pela aplicação Laravel.

### Blade + Livewire 3

Blade é o template engine nativo do Laravel. Livewire adiciona reatividade sem JavaScript customizado — componentes PHP renderizam HTML e respondem a interações via AJAX automático. Elimina a necessidade de uma API REST separada ou de SPA framework.

### Tailwind CSS 4

Utility-first CSS para prototipagem rápida e design consistente. Integrado ao Laravel via Vite.

## Arquitetura

```
Navegador
    │
    ▼
Laravel (Blade + Livewire + Tailwind)
    │
    ▼
Eloquent ORM
    │
    ▼
MySQL 8
```

Modelo síncrono: requisições HTTP → controllers/Livewire components → Eloquent → MySQL. Sem camada de API intermediária.

## Organização do Repositório

- `database/` — Schema Oracle (DDL, migrations, seeds, diagramas, documentação acadêmica)
- `database/mysql/` — DDL MySQL equivalente para execução
- `backend/` — Aplicação Laravel (app/, routes/, resources/, database/migrations)
- `Docs/` — Documentação do projeto e milestones
