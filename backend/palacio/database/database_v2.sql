CREATE DATABASE IF NOT EXISTS palacio_mental
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE palacio_mental;

-- =====================================================
-- TAG
-- =====================================================

CREATE TABLE tag (
    id_tag INT AUTO_INCREMENT PRIMARY KEY,
    nm_tag VARCHAR(50) NOT NULL
);

-- =====================================================
-- USUARIO
-- =====================================================

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nm_usuario VARCHAR(50) NOT NULL,
    nm_email_usuario VARCHAR(100) NOT NULL UNIQUE,
    cd_senha_usuario VARCHAR(255) NOT NULL,
    nm_apelido_usuario VARCHAR(50) UNIQUE,
    ds_bio_usuario VARCHAR(500),
    avatar_url VARCHAR(250),
    dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- CATEGORIA
-- =====================================================

CREATE TABLE categoria (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nm_categoria VARCHAR(50) NOT NULL
);

-- =====================================================
-- PROJETO
-- =====================================================

CREATE TABLE projeto (
    id_projeto INT AUTO_INCREMENT PRIMARY KEY,

    id_usuario INT NOT NULL,
    id_categoria INT NOT NULL,

    nm_projeto VARCHAR(100) NOT NULL,

    ds_projeto LONGTEXT,

    url_repositorio VARCHAR(250),
    url_site VARCHAR(250),

    procurando_colaborador ENUM('S','N')
        DEFAULT 'N',

    st_projeto ENUM(
        'publico',
        'privado',
        'rascunho'
    ) DEFAULT 'rascunho',

    dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    dt_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_proj_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE,

    CONSTRAINT fk_proj_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categoria(id_categoria)
);

CREATE INDEX idx_projeto_usuario
ON projeto(id_usuario);

CREATE INDEX idx_projeto_categoria
ON projeto(id_categoria);

-- =====================================================
-- MIDIA
-- =====================================================

CREATE TABLE midia (
    id_midia INT AUTO_INCREMENT PRIMARY KEY,

    id_projeto INT NOT NULL,

    tp_midia ENUM(
        'imagem',
        'video',
        'audio',
        'texto'
    ) NOT NULL,

    nm_url VARCHAR(255) NOT NULL,

    dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_midia_projeto
        FOREIGN KEY (id_projeto)
        REFERENCES projeto(id_projeto)
        ON DELETE CASCADE
);

-- =====================================================
-- COMENTARIO
-- =====================================================

CREATE TABLE comentario (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,

    id_usuario INT NOT NULL,
    id_projeto INT NOT NULL,

    ds_comentario VARCHAR(1000) NOT NULL,

    dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_comentario_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE,

    CONSTRAINT fk_comentario_projeto
        FOREIGN KEY (id_projeto)
        REFERENCES projeto(id_projeto)
        ON DELETE CASCADE
);

-- =====================================================
-- VAGA
-- =====================================================

CREATE TABLE vaga (
    id_vaga INT AUTO_INCREMENT PRIMARY KEY,

    id_projeto INT NOT NULL,

    nm_vaga VARCHAR(50) NOT NULL,

    ds_vaga VARCHAR(200),

    CONSTRAINT fk_vaga_projeto
        FOREIGN KEY (id_projeto)
        REFERENCES projeto(id_projeto)
        ON DELETE CASCADE
);

-- =====================================================
-- MEMBROS DO PROJETO
-- =====================================================

CREATE TABLE projeto_membro (
    id_projeto INT NOT NULL,
    id_usuario INT NOT NULL,

    papel VARCHAR(30),

    PRIMARY KEY (
        id_projeto,
        id_usuario
    ),

    FOREIGN KEY (id_projeto)
        REFERENCES projeto(id_projeto)
        ON DELETE CASCADE,

    FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE
);

-- =====================================================
-- FEEDBACK
-- =====================================================

CREATE TABLE feedback (
    id_feedback INT AUTO_INCREMENT PRIMARY KEY,

    id_usuario INT NOT NULL,
    id_projeto INT NOT NULL,

    nr_nota TINYINT,

    ds_feedback VARCHAR(500),

    dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CHECK (nr_nota BETWEEN 1 AND 10),

    FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE,

    FOREIGN KEY (id_projeto)
        REFERENCES projeto(id_projeto)
        ON DELETE CASCADE
);

-- =====================================================
-- NOTIFICACOES
-- =====================================================

CREATE TABLE notificacao (
    id_notificacao INT AUTO_INCREMENT PRIMARY KEY,

    id_usuario INT NOT NULL,

    ds_notificacao VARCHAR(200),

    lida ENUM('S','N')
        DEFAULT 'N',

    dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE
);

-- =====================================================
-- PROJETO TAG
-- =====================================================

CREATE TABLE projeto_tag (
    id_projeto INT NOT NULL,
    id_tag INT NOT NULL,

    PRIMARY KEY (
        id_projeto,
        id_tag
    ),

    FOREIGN KEY (id_projeto)
        REFERENCES projeto(id_projeto)
        ON DELETE CASCADE,

    FOREIGN KEY (id_tag)
        REFERENCES tag(id_tag)
        ON DELETE CASCADE
);

-- =====================================================
-- CURTIDA
-- =====================================================

CREATE TABLE curtida (
    id_projeto INT NOT NULL,
    id_usuario INT NOT NULL,

    dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (
        id_projeto,
        id_usuario
    ),

    FOREIGN KEY (id_projeto)
        REFERENCES projeto(id_projeto)
        ON DELETE CASCADE,

    FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE
);

-- =====================================================
-- SALVO
-- =====================================================

CREATE TABLE salvo (
    id_usuario INT NOT NULL,
    id_projeto INT NOT NULL,

    dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (
        id_usuario,
        id_projeto
    ),

    FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE,

    FOREIGN KEY (id_projeto)
        REFERENCES projeto(id_projeto)
        ON DELETE CASCADE
);

-- =====================================================
-- SEGUIDORES
-- =====================================================

CREATE TABLE seguidor (
    id_seguidor INT NOT NULL,
    id_seguido INT NOT NULL,

    dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (
        id_seguidor,
        id_seguido
    ),

    FOREIGN KEY (id_seguidor)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE,

    FOREIGN KEY (id_seguido)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE
);

-- =====================================================
-- ÍNDICES EXTRAS
-- =====================================================

CREATE INDEX idx_comentario_usuario
ON comentario(id_usuario);

CREATE INDEX idx_comentario_projeto
ON comentario(id_projeto);

CREATE INDEX idx_midia_projeto
ON midia(id_projeto);

CREATE INDEX idx_curtida_usuario
ON curtida(id_usuario);

CREATE INDEX idx_curtida_projeto
ON curtida(id_projeto);

CREATE INDEX idx_salvo_usuario
ON salvo(id_usuario);

CREATE INDEX idx_salvo_projeto
ON salvo(id_projeto);
