# 🚀 Palácio Mental — Guia de Deploy & DevOps

> Documento completo de infraestrutura, desde o desenvolvimento local (Laravel + MySQL) até o deploy em produção (Vercel Serverless + Neon PostgreSQL).

---

## 📋 Sumário

- [Arquitetura](#arquitetura)
- [Stack Local vs Produção](#stack-local-vs-produção)
- [Pré-requisitos](#pré-requisitos)
- [Configuração Local](#configuração-local)
- [Deploy na Vercel + Neon](#deploy-na-vercel--neon)
- [Variáveis de Ambiente](#variáveis-de-ambiente)
- [Problemas Encontrados e Soluções](#problemas-encontrados-e-soluções)
- [Health Check API](#health-check-api)
- [Manutenção e Troubleshooting](#manutenção-e-troubleshooting)
- [Limpeza e Rollback](#limpeza-e-rollback)

---

## Arquitetura

```
┌─────────────────────────────────────────────────────────────┐
│                        VERCEL                               │
│  ┌──────────────┐    ┌──────────────────────────────────┐   │
│  │   CDN/Edge   │───▶│  Serverless Function (vercel-php) │   │
│  │  (assets/    │    │  api/index.php → Laravel 13       │   │
│  │   build/)    │    │  PHP 8.3 / Amazon Linux 2        │   │
│  └──────────────┘    │  Storage: /tmp (read-only FS)     │   │
│                      └────────────┬─────────────────────┘   │
│                                   │                          │
│                      ┌────────────▼─────────────────────┐   │
│                      │  /tmp/storage_palaciomental       │   │
│                      │  ├── bootstrap/cache/ (services,  │   │
│                      │  │   packages, config, events)    │   │
│                      │  ├── framework/cache/data/        │   │
│                      │  ├── framework/sessions/          │   │
│                      │  ├── framework/views/             │   │
│                      │  └── logs/                        │   │
│                      └──────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
                                    │
                                    ▼ TCP (pooled)
┌─────────────────────────────────────────────────────────────┐
│                     NEON POSTGRESQL                          │
│  ┌──────────────────┐    ┌───────────────────────────────┐  │
│  │  Pooler Endpoint  │───▶│  Database: neondb             │  │
│  │  (ep-...-pooler)  │    │  - users, sessions, cache     │  │
│  │  Port 5432        │    │  - projetos, tags, comentarios│  │
│  │                    │    │  - curtidas, salvos, etc.     │  │
│  └──────────────────┘    └───────────────────────────────┘  │
│  Branching: main (production)                                │
│  Auto-suspend: 5 min inatividade                            │
└─────────────────────────────────────────────────────────────┘
```

---

## Stack Local vs Produção

| Componente       | Local                    | Produção                        |
|------------------|--------------------------|---------------------------------|
| **Runtime**      | PHP 8.3 built-in server  | vercel-php@0.7.4 (Serverless)   |
| **Framework**    | Laravel 13               | Laravel 13                      |
| **Database**     | MySQL 8                  | Neon PostgreSQL 17              |
| **Cache**        | `database` driver        | `database` driver               |
| **Session**      | `database` driver        | `database` driver               |
| **Storage**      | `storage/` (writable)    | `/tmp/storage_palaciomental`    |
| **Assets**       | Vite dev server (5173)   | Vite build → `/public/build/`   |
| **Queue**        | `database` driver        | `database` driver               |
| **Logging**      | `storage/logs/laravel.log` | `/tmp/storage_palaciomental/logs/` |

---

## Pré-requisitos

- **PHP** 8.3+
- **Composer** 2.x
- **Node.js** 18+ & **npm**
- **Git**
- **Vercel CLI** (`npm i -g vercel`)
- **Neon CLI** (opcional, para gerenciar o banco)

---

## Configuração Local

```bash
# 1. Clone o repositório
git clone https://github.com/DevTroli/palacioMental.git
cd palacioMental/backend

# 2. Instale dependências PHP e JS
composer install
npm install

# 3. Configure o .env
cp .env.example .env
php artisan key:generate

# 4. Configure o banco MySQL local no .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=palacio_mental
# DB_USERNAME=palacio
# DB_PASSWORD=secret

# 5. Rode as migrations
php artisan migrate

# 6. Compile os assets
npm run build

# 7. Inicie o servidor
php artisan serve
```

---

## Deploy na Vercel + Neon

### Passo 1 — Criar o banco Neon PostgreSQL

1. Acesse [neon.tech](https://neon.tech) e crie um projeto
2. Anote a **connection string** (use o endpoint **pooler** para serverless):
   ```
   postgresql://neondb_owner:password@ep-long-recipe-akwl2mia-pooler.c-3.us-west-2.aws.neon.tech/neondb?sslmode=require
   ```

3. Rode as migrations no Neon:
   ```bash
   # Configura o .env local para apontar para o Neon temporariamente
   DB_CONNECTION=pgsql
   DB_HOST=ep-long-recipe-akwl2mia-pooler.c-3.us-west-2.aws.neon.tech
   DB_PORT=5432
   DB_DATABASE=neondb
   DB_USERNAME=neondb_owner
   DB_PASSWORD=<sua-senha>
   
   php artisan migrate --force
   ```

4. **Atenção para pivot tables**: Se usar `withTimestamps()` em relationships Eloquent, 
   as tabelas pivot precisam de `created_at` e `updated_at`:
   ```sql
   ALTER TABLE projeto_tag ADD COLUMN created_at TIMESTAMP NULL;
   ALTER TABLE projeto_tag ADD COLUMN updated_at TIMESTAMP NULL;
   ```

### Passo 2 — Criar o projeto na Vercel

1. Acesse [vercel.com](https://vercel.com) → "New Project"
2. Importe o repositório GitHub `DevTroli/palacioMental`
3. **Root Directory**: `backend` (CRITICAL — o Laravel está na subpasta `backend/`)
4. **Framework Preset**: Other (não detecte automaticamente)

### Passo 3 — Configurar o Vercel

O `backend/vercel.json` já está configurado:

```json
{
  "version": 2,
  "framework": null,
  "outputDirectory": "public",
  "functions": {
    "api/index.php": {
      "runtime": "vercel-php@0.7.4",
      "maxDuration": 10,
      "excludeFiles": "{public,storage,resources,tests,database,lang}"
    }
  },
  "routes": [
    { "src": "/build/(.*)", "dest": "/public/build/$1" },
    { "src": "/palaciomental.png", "dest": "/public/palaciomental.png" },
    { "src": "/robots.txt", "dest": "/public/robots.txt" },
    { "src": "/favicon.ico", "dest": "/public/favicon.ico" },
    { "src": "/(.*)", "dest": "/api/index.php" }
  ]
}
```

**Pontos críticos:**
- `runtime: "vercel-php@0.7.4"` — Suporta PHP 8.3. Versões anteriores (0.5.x) usam Node.js 14 (deprecated).
- `excludeFiles` — Remove diretórios pesados do bundle serverless.
- `routes` — Assets em `/build/` são servidos estaticamente pelo CDN; tudo else vai para Laravel.

### Passo 4 — Configurar Variáveis de Ambiente

Na Vercel: **Settings → Environment Variables**, adicione TODAS:

```
APP_NAME=Palácio Mental
APP_ENV=production
APP_KEY=base64:...  (copie do seu .env local)
APP_DEBUG=false
APP_URL=https://palacio-mental.vercel.app

DB_CONNECTION=pgsql
DB_HOST=ep-long-recipe-akwl2mia-pooler.c-3.us-west-2.aws.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=neondb_owner
DB_PASSWORD=<sua-senha-neon>

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

LOG_CHANNEL=stderr

VERCEL=1
```

> ⚠️ **VERCEL=1** é a flag que ativa o modo serverless no código (`api/index.php` e `AppServiceProvider`).

### Passo 5 — Verificar o Root Directory via API

Se o Vercel não respeitar o root directory do GitHub, corrija via API:

```bash
curl -X PATCH "https://api.vercel.com/v9/projects/prj_XXXX" \
  -H "Authorization: Bearer $VERCEL_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"rootDirectory": "backend"}'
```

### Passo 6 — Desabilitar SSO Protection

Se o projeto tiver SSO Protection ativado (bloqueia acesso público):

```bash
curl -X PATCH "https://api.vercel.com/v9/projects/prj_XXXX?teamId=team_XXXX" \
  -H "Authorization: Bearer $VERCEL_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"ssoProtection": null}'
```

### Passo 7 — Deploy!

Push para `main` no GitHub aciona deploy automático, ou:

```bash
cd backend
vercel --prod
```

---

## Variáveis de Ambiente

### Produção (Vercel) — Obrigatórias

| Variável          | Valor/Exemplo                                       | Nota                              |
|-------------------|------------------------------------------------------|-----------------------------------|
| `APP_NAME`        | `Palácio Mental`                                     |                                   |
| `APP_ENV`         | `production`                                         |                                   |
| `APP_KEY`         | `base64:...`                                         | Gerado por `php artisan key:generate` |
| `APP_DEBUG`       | `false`                                              | **SEMPRE false em produção!**     |
| `APP_URL`         | `https://palacio-mental.vercel.app`                  |                                   |
| `DB_CONNECTION`   | `pgsql`                                              | Neon = PostgreSQL                 |
| `DB_HOST`         | `ep-...-pooler.c-3.us-west-2.aws.neon.tech`          | **Use o endpoint POOLER**         |
| `DB_PORT`         | `5432`                                               |                                   |
| `DB_DATABASE`     | `neondb`                                             |                                   |
| `DB_USERNAME`     | `neondb_owner`                                       |                                   |
| `DB_PASSWORD`     | *(senha do Neon)*                                    |                                   |
| `SESSION_DRIVER`  | `database`                                           | File sessions não funcionam em serverless |
| `CACHE_STORE`     | `database`                                           | File cache não funciona em serverless |
| `QUEUE_CONNECTION`| `database`                                           |                                   |
| `LOG_CHANNEL`     | `stderr`                                             | Logs vão para o Vercel Runtime Logs |
| `VERCEL`          | `1`                                                  | Flag de modo serverless           |

### Produção (Vercel) — Opcionais (auto-gerenciadas)

| Variável                | Valor                                          | Nota                              |
|-------------------------|------------------------------------------------|-----------------------------------|
| `APP_SERVICES_CACHE`    | `/tmp/storage_palaciomental/bootstrap/cache/services.php` | Set em `api/index.php`     |
| `APP_PACKAGES_CACHE`    | `/tmp/.../bootstrap/cache/packages.php`        | Set em `api/index.php`            |
| `APP_CONFIG_CACHE`      | `/tmp/.../bootstrap/cache/config.php`          | Set em `api/index.php`            |
| `APP_EVENTS_CACHE`      | `/tmp/.../bootstrap/cache/events.php`          | Set em `api/index.php`            |
| `APP_STORAGE_PATH`      | `/tmp/storage_palaciomental`                   | Set em `api/index.php`            |

---

## Problemas Encontrados e Soluções

### ❌ `"Please provide a valid cache path"`

**Causa**: Vercel serverless tem filesystem read-only. Laravel tenta escrever em `storage/framework/cache/` e falha.

**Solução**: Todos os caminhos de storage são redirecionados para `/tmp/` em `api/index.php`:
```php
if ($isServerless) {
    $tmp = '/tmp/storage_palaciomental';
    // Cria diretórios em /tmp
    // Seta env vars: APP_SERVICES_CACHE, APP_CONFIG_CACHE, etc.
    // Seta APP_STORAGE_PATH
}
```

O `AppServiceProvider` complementa com overrides de config:
```php
config([
    'view.compiled'          => $tmp . '/framework/views',
    'cache.stores.file.path' => $tmp . '/framework/cache/data',
    'session.files'          => $tmp . '/framework/sessions',
    'logging.channels.single.path' => $tmp . '/logs/laravel.log',
]);
```

---

### ❌ `"Class Laravel\Pail\PailServiceProvider not found"`

**Causa**: Vercel roda `composer install --no-dev`, removendo pacotes em `require-dev`. O `laravel/pail` estava em `require-dev` mas é registrado em `bootstrap/providers.php`.

**Solução**: Mover pacotes necessários em produção de `require-dev` para `require` no `composer.json`:
```json
"require": {
    "laravel/breeze": "^2.4",
    "laravel/pail": "^1.2.5",
    "laravel/pao": "^1.0.6"
}
```

**Regra**: Qualquer pacote registrado em `bootstrap/providers.php` DEVE estar em `require` (nunca `require-dev`).

---

### ❌ `"Target class [view] does not exist"`

**Causa**: O `services.php` cacheado em `bootstrap/cache/` referenciava providers que não existiam em produção (removidos pelo `--no-dev`). Quando copiado para `/tmp/`, causava crash.

**Solução**: **NÃO copiar** o bootstrap cache pré-compilado. Deixar Laravel regenerar fresh:
```php
// Em api/index.php — NÃO copiar bootstrap/cache/* para /tmp
// Apenas setar os caminhos e deixar Laravel criar os caches do zero
putenv("APP_SERVICES_CACHE=$tmpBootstrap/services.php");
```

---

### ❌ CSS do Tailwind não carrega (Vite dev mode em produção)

**Causa**: O arquivo `public/hot` existia no deploy. Quando `@vite()` encontra esse arquivo, ele gera URLs do dev server (`http://[::1]:5173/...`) ao invés dos assets compilados.

**Solução** (3 camadas de proteção):
1. **Remover** `public/hot` do repositório
2. **Garantir** que `public/build/` NÃO está no `.gitignore` (precisa ser commitado)
3. **Forçar** Vite a usar build mode em produção no `AppServiceProvider`:
```php
if (env('VERCEL')) {
    Vite::hotFile('/non-existent-hot-file');  // Nunca encontrará "hot"
    Vite::useBuildDirectory('build');
}
```

---

### ❌ `tempnam()` warnings no log

**Causa**: PHP em serverless tenta criar arquivos temporários e gera warnings porque o filesystem é read-only.

**Solução**: Suprimir warnings específicos em `api/index.php`:
```php
if ($isServerless) {
    set_error_handler(function ($severity, $message) {
        if (str_contains($message, 'tempnam') || str_contains($message, 'sys_get_temp_dir')) {
            return true; // Suprimir
        }
        return false; // Propagar outros erros
    }, E_WARNING);
}
```

---

### ❌ SSO Protection bloqueando acesso público

**Causa**: Vercel pode ativar SSO Protection automaticamente em alguns planos, bloqueando acesso sem login.

**Solução**: Desabilitar via API:
```bash
curl -X PATCH "https://api.vercel.com/v9/projects/PROJECT_ID?teamId=TEAM_ID" \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"ssoProtection": null}'
```

---

### ❌ Pivot tables sem timestamps

**Causa**: Eloquent `belongsToMany()->withTimestamps()` exige `created_at` e `updated_at` na tabela pivot, mas migrations não criaram essas colunas.

**Solução**: Adicionar colunas manualmente no Neon:
```sql
ALTER TABLE projeto_tag ADD COLUMN created_at TIMESTAMP NULL;
ALTER TABLE projeto_tag ADD COLUMN updated_at TIMESTAMP NULL;
```

---

### ❌ `vercel-php@0.5.2` — Node.js 14 deprecated

**Causa**: Versão antiga do runtime PHP usava Node.js 14, que foi descontinuado.

**Solução**: Atualizar para `vercel-php@0.7.4` no `vercel.json`:
```json
"runtime": "vercel-php@0.7.4"
```

---

## Health Check API

O endpoint `/api/health` retorna o status de todos os componentes do sistema:

```bash
curl https://palacio-mental.vercel.app/api/health
```

**Resposta de exemplo:**

```json
{
  "status": "healthy",
  "checks": {
    "app": {
      "name": "Palácio Mental",
      "env": "production",
      "debug": false,
      "php": "8.3.x",
      "laravel": "13.x"
    },
    "database": {
      "status": "ok",
      "driver": "pgsql",
      "database": "neondb",
      "latency": "12.5ms",
      "can_read": true
    },
    "cache": {
      "status": "ok",
      "driver": "database",
      "latency": "8.3ms",
      "can_write_and_read": true
    },
    "storage": {
      "status": "ok",
      "is_serverless": true,
      "can_write": true,
      "writable_dirs": { ... }
    },
    "session": { "driver": "database" },
    "assets": {
      "manifest_exists": true,
      "hot_file_exists": false,
      "build_dir": true
    },
    "serverless": {
      "is_vercel": true,
      "runtime": "vercel-php"
    },
    "meta": {
      "total_latency": "25.1ms",
      "timestamp": "2026-05-27T12:00:00Z"
    }
  }
}
```

**Status codes:**
- `200` — Todos os componentes saudáveis
- `503` — Um ou mais componentes com problemas

O endpoint Laravel interno `/up` retorna um check simples: `{"status":"up"}`.

---

## Manutenção e Troubleshooting

### Verificar logs em produção

```bash
# Via Vercel CLI
vercel logs https://palacio-mental.vercel.app

# Ou pelo dashboard: https://vercel.com/dashboard → Project → Logs
```

### Rodar migrations no Neon

```bash
# Temporariamente aponte o .env para Neon
php artisan migrate --force
```

### Limpar caches em /tmp (serverless)

Caches em `/tmp` são automaticamente limpos entre cold starts. 
Se precisar forçar, basta fazer um redeploy na Vercel.

### Verificar status do Neon

```bash
# Neon Console: https://console.neon.tech
# Verifique: conexões ativas, storage usage, branch status
```

### Debug local simulando serverless

```bash
# Set as variáveis de serverless localmente
export VERCEL=1
export APP_ENV=production
export DB_CONNECTION=pgsql
# ... (outras vars do Neon)

php artisan serve
```

---

## Limpeza e Rollback

### Rollback de deploy

```bash
# Listar deployments
vercel ls

# Promover um deployment anterior
vercel inspect <deployment-url>
vercel --prod <deployment-url>
```

### Deletar branch no Neon (se usou branching para migration)

```bash
# Via Neon Console ou CLI
neon branches delete --project-id <project-id> --branch-id <branch-id>
```

### Deletar projeto duplicado na Vercel

Se criou projetos duplicados acidentalmente:
```bash
# Via API
curl -X DELETE "https://api.vercel.com/v9/projects/PROJECT_ID?teamId=TEAM_ID" \
  -H "Authorization: Bearer TOKEN"
```

---

## Checklist de Deploy

- [ ] Banco Neon criado e acessível
- [ ] Migrations rodadas no Neon
- [ ] Pivot tables com timestamps (se aplicável)
- [ ] `APP_KEY` configurada na Vercel
- [ ] `APP_DEBUG=false` na Vercel
- [ ] `VERCEL=1` configurado
- [ ] `SESSION_DRIVER=database` (não file!)
- [ ] `CACHE_STORE=database` (não file!)
- [ ] `LOG_CHANNEL=stderr`
- [ ] Root Directory = `backend` na Vercel
- [ ] SSO Protection desabilitado
- [ ] `public/hot` removido do repo
- [ ] `public/build/` commitado no repo
- [ ] `composer.json` com packages corretos em `require` (não `require-dev`)
- [ ] `vercel-php@0.7.4` no `vercel.json`
- [ ] Health check respondendo: `/api/health` → 200
- [ ] `/up` respondendo: `{"status":"up"}`

---

*Última atualização: Maio 2026*
