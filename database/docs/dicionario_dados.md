# Dicionário de Dados — Palácio Mental

## Visão Geral

Documento de referência para todas as entidades, colunas, tipos, constraints e relacionamentos do banco de dados Palácio Mental. Inclui mapeamento Oracle → MySQL.

---

## Tabela: users (Oracle: USUARIO)

Armazena dados dos usuários da plataforma.

| Coluna | Oracle | MySQL | Tipo MySQL | Nulo | Default | Constraint | Descrição |
|--------|--------|-------|------------|------|---------|------------|-----------|
| id | id_usuario (SEQUENCE) | id | BIGINT UNSIGNED AUTO_INCREMENT | NOT NULL | — | PK | Identificador único do usuário |
| name | nm_usuario | name | VARCHAR(50) | NOT NULL | — | — | Nome completo do usuário |
| email | nm_email_usuario | email | VARCHAR(100) | NOT NULL | — | UNIQUE | E-mail para login e contato |
| password | cd_senha_usuario | password | VARCHAR(255) | NOT NULL | — | — | Hash da senha (bcrypt) |
| username | nm_apelido_usuario | username | VARCHAR(50) | YES | NULL | UNIQUE | Apelido público visível no perfil |
| bio | ds_bio_usuario | bio | TEXT | YES | NULL | — | Biografia/descrição do perfil |
| avatar_url | avatar_url | avatar_url | VARCHAR(300) | YES | NULL | — | URL da foto de perfil |
| created_at | dt_criacao | created_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP | — | Data de cadastro |
| updated_at | — | updated_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP ON UPDATE | — | Data da última alteração |

---

## Tabela: categorias (Oracle: CATEGORIA)

Classificação dos projetos por área de conhecimento.

| Coluna | Oracle | MySQL | Tipo MySQL | Nulo | Default | Constraint | Descrição |
|--------|--------|-------|------------|------|---------|------------|-----------|
| id | id_categoria (SEQUENCE) | id | BIGINT UNSIGNED AUTO_INCREMENT | NOT NULL | — | PK | Identificador único da categoria |
| nome | nm_categoria | nome | VARCHAR(50) | NOT NULL | — | UNIQUE | Nome da categoria (ex: Desenvolvimento Web) |
| created_at | — | created_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP | — | Data de criação |
| updated_at | — | updated_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP ON UPDATE | — | Data da última alteração |

---

## Tabela: tags (Oracle: TAG)

Etiquetas livres para categorização flexível de projetos.

| Coluna | Oracle | MySQL | Tipo MySQL | Nulo | Default | Constraint | Descrição |
|--------|--------|-------|------------|------|---------|------------|-----------|
| id | id_tag (SEQUENCE) | id | BIGINT UNSIGNED AUTO_INCREMENT | NOT NULL | — | PK | Identificador único da tag |
| nome | nm_tag | nome | VARCHAR(50) | NOT NULL | — | UNIQUE | Nome da tag (ex: react, api) |
| created_at | — | created_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP | — | Data de criação |
| updated_at | — | updated_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP ON UPDATE | — | Data da última alteração |

---

## Tabela: projetos (Oracle: PROJETO)

Entidade central — projetos compartilhados na plataforma.

| Coluna | Oracle | MySQL | Tipo MySQL | Nulo | Default | Constraint | Descrição |
|--------|--------|-------|------------|------|---------|------------|-----------|
| id | id_projeto (SEQUENCE) | id | BIGINT UNSIGNED AUTO_INCREMENT | NOT NULL | — | PK | Identificador único do projeto |
| user_id | id_usuario | user_id | BIGINT UNSIGNED | NOT NULL | — | FK → users(id) | Autor do projeto |
| categoria_id | id_categoria | categoria_id | BIGINT UNSIGNED | YES | NULL | FK → categorias(id) | Categoria do projeto |
| titulo | nm_projeto | titulo | VARCHAR(200) | NOT NULL | — | — | Título do projeto |
| descricao | ds_projeto | descricao | LONGTEXT | YES | NULL | — | Descrição detalhada do projeto |
| status | st_projeto | status | ENUM('rascunho','publico','privado') | NOT NULL | 'rascunho' | CHECK | Estado de visibilidade do projeto |
| created_at | dt_criacao | created_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP | — | Data de criação |
| updated_at | dt_atualizacao | updated_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP ON UPDATE | — | Data da última alteração |

**Indexes:** idx_projetos_user_id, idx_projetos_categoria_id

---

## Tabela: midias (Oracle: MIDIA)

Arquivos multimídia vinculados a projetos (entidade fraca).

| Coluna | Oracle | MySQL | Tipo MySQL | Nulo | Default | Constraint | Descrição |
|--------|--------|-------|------------|------|---------|------------|-----------|
| id | id_midia (SEQUENCE) | id | BIGINT UNSIGNED AUTO_INCREMENT | NOT NULL | — | PK | Identificador único da mídia |
| projeto_id | id_projeto | projeto_id | BIGINT UNSIGNED | NOT NULL | — | FK → projetos(id) CASCADE | Projeto ao qual a mídia pertence |
| tipo | tp_midia | tipo | ENUM('imagem','video','audio','texto') | NOT NULL | — | CHECK | Tipo do arquivo de mídia |
| url | url_midia | url | VARCHAR(600) | NOT NULL | — | — | URL ou caminho do arquivo |
| created_at | dt_criacao | created_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP | — | Data de upload |
| updated_at | — | updated_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP ON UPDATE | — | Data da última alteração |

**Indexes:** idx_midias_projeto_id

---

## Tabela: comentarios (Oracle: COMENTARIO)

Comentários dos usuários em projetos.

| Coluna | Oracle | MySQL | Tipo MySQL | Nulo | Default | Constraint | Descrição |
|--------|--------|-------|------------|------|---------|------------|-----------|
| id | id_comentario (SEQUENCE) | id | BIGINT UNSIGNED AUTO_INCREMENT | NOT NULL | — | PK | Identificador único do comentário |
| user_id | id_usuario | user_id | BIGINT UNSIGNED | NOT NULL | — | FK → users(id) CASCADE | Autor do comentário |
| projeto_id | id_projeto | projeto_id | BIGINT UNSIGNED | NOT NULL | — | FK → projetos(id) CASCADE | Projeto comentado |
| conteudo | ds_comentario | conteudo | TEXT | NOT NULL | — | — | Texto do comentário |
| created_at | dt_criacao | created_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP | — | Data do comentário |
| updated_at | — | updated_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP ON UPDATE | — | Data da última alteração |

**Indexes:** idx_comentarios_projeto_id, idx_comentarios_user_id

---

## Tabela: projeto_tag (Oracle: PROJETO_TAG)

Tabela associativa N:M entre projetos e tags.

| Coluna | Oracle | MySQL | Tipo MySQL | Nulo | Default | Constraint | Descrição |
|--------|--------|-------|------------|------|---------|------------|-----------|
| projeto_id | id_projeto | projeto_id | BIGINT UNSIGNED | NOT NULL | — | PK, FK → projetos(id) CASCADE | Referência ao projeto |
| tag_id | id_tag | tag_id | BIGINT UNSIGNED | NOT NULL | — | PK, FK → tags(id) CASCADE | Referência à tag |

**PK composta:** (projeto_id, tag_id)

**Indexes:** idx_projeto_tag_projeto_id, idx_projeto_tag_tag_id

---

## Tabela: curtidas (Oracle: CURTIDA)

Registro de curtidas em projetos (um usuário curte um projeto uma vez).

| Coluna | Oracle | MySQL | Tipo MySQL | Nulo | Default | Constraint | Descrição |
|--------|--------|-------|------------|------|---------|------------|-----------|
| projeto_id | id_projeto | projeto_id | BIGINT UNSIGNED | NOT NULL | — | PK, FK → projetos(id) CASCADE | Projeto curtido |
| user_id | id_usuario | user_id | BIGINT UNSIGNED | NOT NULL | — | PK, FK → users(id) CASCADE | Usuário que curtiu |
| created_at | dt_criacao | created_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP | — | Momento da curtida |

**PK composta:** (projeto_id, user_id)

**Indexes:** idx_curtidas_projeto_id, idx_curtidas_user_id

---

## Tabela: salvos (Oracle: SALVO)

Projetos salvos/favoritados por usuários.

| Coluna | Oracle | MySQL | Tipo MySQL | Nulo | Default | Constraint | Descrição |
|--------|--------|-------|------------|------|---------|------------|-----------|
| user_id | id_usuario | user_id | BIGINT UNSIGNED | NOT NULL | — | PK, FK → users(id) CASCADE | Usuário que salvou |
| projeto_id | id_projeto | projeto_id | BIGINT UNSIGNED | NOT NULL | — | PK, FK → projetos(id) CASCADE | Projeto salvo |
| created_at | dt_criacao | created_at | DATETIME | NOT NULL | CURRENT_TIMESTAMP | — | Momento em que salvou |

**PK composta:** (user_id, projeto_id)

**Indexes:** idx_salvos_user_id, idx_salvos_projeto_id

---

## Relacionamentos

| Origem | Destino | Cardinalidade | FK |
|--------|---------|---------------|----|
| projetos.user_id | users.id | N:1 | Um projeto pertence a um usuário |
| projetos.categoria_id | categorias.id | N:1 (opcional) | Um projeto pode ter uma categoria |
| midias.projeto_id | projetos.id | N:1 | Uma mídia pertence a um projeto |
| comentarios.user_id | users.id | N:1 | Um comentário pertence a um usuário |
| comentarios.projeto_id | projetos.id | N:1 | Um comentário pertence a um projeto |
| projeto_tag.projeto_id | projetos.id | N:M (via pivot) | Tag associada a projeto |
| projeto_tag.tag_id | tags.id | N:M (via pivot) | Projeto associado a tag |
| curtidas.projeto_id | projetos.id | N:M (via pivot) | Curtida de usuário em projeto |
| curtidas.user_id | users.id | N:M (via pivot) | Usuário que curtiu projeto |
| salvos.user_id | users.id | N:M (via pivot) | Usuário que salvou projeto |
| salvos.projeto_id | projetos.id | N:M (via pivot) | Projeto salvo pelo usuário |