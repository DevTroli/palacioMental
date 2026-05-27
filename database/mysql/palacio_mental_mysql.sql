-- ============================================================
-- Palácio Mental — DDL MySQL 8
-- Equivalente ao schema Oracle em ../palacio_mental.sql
-- ============================================================
-- Mapeamentos:
--   SEQUENCE + TRIGGER  → AUTO_INCREMENT
--   VARCHAR2            → VARCHAR / LONGTEXT
--   DATE (com hora)     → DATETIME
--   SYSDATE             → CURRENT_TIMESTAMP
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- -----------------------------------------------------------
-- Tabela: categorias  (Oracle: CATEGORIA)
-- -----------------------------------------------------------
DROP TABLE IF EXISTS categorias;
CREATE TABLE categorias (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome       VARCHAR(50)     NOT NULL,
    created_at DATETIME        DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME        DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_categorias PRIMARY KEY (id),
    CONSTRAINT uq_categorias_nome UNIQUE (nome)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- Tabela: tags  (Oracle: TAG)
-- -----------------------------------------------------------
DROP TABLE IF EXISTS tags;
CREATE TABLE tags (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome       VARCHAR(50)     NOT NULL,
    created_at DATETIME        DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME        DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_tags PRIMARY KEY (id),
    CONSTRAINT uq_tags_nome UNIQUE (nome)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- Tabela: users  (Oracle: USUARIO)
-- -----------------------------------------------------------
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name        VARCHAR(50)     NOT NULL,
    email       VARCHAR(100)    NOT NULL,
    password    VARCHAR(255)    NOT NULL,
    username    VARCHAR(50)     DEFAULT NULL,
    bio         TEXT            DEFAULT NULL,
    avatar_url  VARCHAR(300)    DEFAULT NULL,
    created_at  DATETIME        DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME        DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_users PRIMARY KEY (id),
    CONSTRAINT uq_users_email    UNIQUE (email),
    CONSTRAINT uq_users_username UNIQUE (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- Tabela: projetos  (Oracle: PROJETO)
-- -----------------------------------------------------------
DROP TABLE IF EXISTS projetos;
CREATE TABLE projetos (
    id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id      BIGINT UNSIGNED NOT NULL,
    categoria_id BIGINT UNSIGNED DEFAULT NULL,
    titulo       VARCHAR(200)    NOT NULL,
    descricao    LONGTEXT        DEFAULT NULL,
    status       ENUM('rascunho','publico','privado') DEFAULT 'rascunho',
    created_at   DATETIME        DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME        DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_projetos PRIMARY KEY (id),
    CONSTRAINT fk_projetos_user_id      FOREIGN KEY (user_id)      REFERENCES users(id)      ON DELETE CASCADE,
    CONSTRAINT fk_projetos_categoria_id FOREIGN KEY (categoria_id)  REFERENCES categorias(id)  ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_projetos_user_id      ON projetos (user_id);
CREATE INDEX idx_projetos_categoria_id ON projetos (categoria_id);

-- -----------------------------------------------------------
-- Tabela: midias  (Oracle: MIDIA)
-- -----------------------------------------------------------
DROP TABLE IF EXISTS midias;
CREATE TABLE midias (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    projeto_id BIGINT UNSIGNED NOT NULL,
    tipo       ENUM('imagem','video','audio','texto') NOT NULL,
    url        VARCHAR(600)    NOT NULL,
    created_at DATETIME        DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME        DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_midias PRIMARY KEY (id),
    CONSTRAINT fk_midias_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_midias_projeto_id ON midias (projeto_id);

-- -----------------------------------------------------------
-- Tabela: comentarios  (Oracle: COMENTARIO)
-- -----------------------------------------------------------
DROP TABLE IF EXISTS comentarios;
CREATE TABLE comentarios (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id    BIGINT UNSIGNED NOT NULL,
    projeto_id BIGINT UNSIGNED NOT NULL,
    conteudo   TEXT            NOT NULL,
    created_at DATETIME        DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME        DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_comentarios PRIMARY KEY (id),
    CONSTRAINT fk_comentarios_user_id    FOREIGN KEY (user_id)    REFERENCES users(id)     ON DELETE CASCADE,
    CONSTRAINT fk_comentarios_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id)  ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_comentarios_projeto_id ON comentarios (projeto_id);
CREATE INDEX idx_comentarios_user_id    ON comentarios (user_id);

-- -----------------------------------------------------------
-- Tabela: projeto_tag  (Oracle: PROJETO_TAG)
-- -----------------------------------------------------------
DROP TABLE IF EXISTS projeto_tag;
CREATE TABLE projeto_tag (
    projeto_id BIGINT UNSIGNED NOT NULL,
    tag_id     BIGINT UNSIGNED NOT NULL,
    CONSTRAINT pk_projeto_tag     PRIMARY KEY (projeto_id, tag_id),
    CONSTRAINT fk_ptag_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id) ON DELETE CASCADE,
    CONSTRAINT fk_ptag_tag_id     FOREIGN KEY (tag_id)     REFERENCES tags(id)     ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_projeto_tag_projeto_id ON projeto_tag (projeto_id);
CREATE INDEX idx_projeto_tag_tag_id     ON projeto_tag (tag_id);

-- -----------------------------------------------------------
-- Tabela: curtidas  (Oracle: CURTIDA)
-- -----------------------------------------------------------
DROP TABLE IF EXISTS curtidas;
CREATE TABLE curtidas (
    projeto_id BIGINT UNSIGNED NOT NULL,
    user_id    BIGINT UNSIGNED NOT NULL,
    created_at DATETIME        DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_curtidas      PRIMARY KEY (projeto_id, user_id),
    CONSTRAINT fk_curtidas_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id) ON DELETE CASCADE,
    CONSTRAINT fk_curtidas_user_id     FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_curtidas_projeto_id ON curtidas (projeto_id);
CREATE INDEX idx_curtidas_user_id    ON curtidas (user_id);

-- -----------------------------------------------------------
-- Tabela: salvos  (Oracle: SALVO)
-- -----------------------------------------------------------
DROP TABLE IF EXISTS salvos;
CREATE TABLE salvos (
    user_id    BIGINT UNSIGNED NOT NULL,
    projeto_id BIGINT UNSIGNED NOT NULL,
    created_at DATETIME        DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_salvos      PRIMARY KEY (user_id, projeto_id),
    CONSTRAINT fk_salvos_user_id     FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    CONSTRAINT fk_salvos_projeto_id  FOREIGN KEY (projeto_id) REFERENCES projetos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_salvos_user_id    ON salvos (user_id);
CREATE INDEX idx_salvos_projeto_id ON salvos (projeto_id);

SET FOREIGN_KEY_CHECKS = 1;
