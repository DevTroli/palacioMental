-- =============================================================
-- PALACIO MENTAL — DDL físico Oracle (v2)
-- =============================================================
-- Ordem de criação respeita dependências de FK:
--   TAG, USUARIO, CATEGORIA → PROJETO → MIDIA, COMENTARIO,
--   PROJETO_TAG, CURTIDA, SALVO
-- =============================================================


-- -------------------------------------------------------------
-- SEQUENCES — uma por tabela, evita colisão de IDs entre tabelas
-- (o DDL gerado usava GlobalSequence única, problema explicado
--  na seção de alterações ao final do arquivo)
-- -------------------------------------------------------------
CREATE SEQUENCE sq_tag       START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE SEQUENCE sq_usuario   START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE SEQUENCE sq_categoria START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE SEQUENCE sq_projeto   START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE SEQUENCE sq_midia     START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE SEQUENCE sq_comentario START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;


-- -------------------------------------------------------------
-- TAG
-- -------------------------------------------------------------
CREATE TABLE TAG (
  id_tag   INTEGER      NOT NULL,
  nm_tag   VARCHAR2(50) NOT NULL,
  CONSTRAINT pk_tag PRIMARY KEY (id_tag)
);

CREATE OR REPLACE TRIGGER trg_tag_bi
BEFORE INSERT ON TAG FOR EACH ROW
BEGIN
  IF :NEW.id_tag IS NULL THEN
    :NEW.id_tag := sq_tag.NEXTVAL;
  END IF;
END;
/


-- -------------------------------------------------------------
-- USUARIO
-- -------------------------------------------------------------
CREATE TABLE USUARIO (
  id_usuario         INTEGER        NOT NULL,
  nm_usuario         VARCHAR2(50)   NOT NULL,
  nm_email_usuario   VARCHAR2(100)  NOT NULL,
  cd_senha_usuario   VARCHAR2(60)   NOT NULL,
  nm_apelido_usuario VARCHAR2(50),
  ds_bio_usuario     VARCHAR2(200),
  avatar_url         VARCHAR2(250),
  dt_criacao         DATE           DEFAULT SYSDATE NOT NULL,
  CONSTRAINT pk_usuario   PRIMARY KEY (id_usuario),
  CONSTRAINT uq_email     UNIQUE      (nm_email_usuario),
  CONSTRAINT uq_apelido   UNIQUE      (nm_apelido_usuario)
);

CREATE OR REPLACE TRIGGER trg_usuario_bi
BEFORE INSERT ON USUARIO FOR EACH ROW
BEGIN
  IF :NEW.id_usuario IS NULL THEN
    :NEW.id_usuario := sq_usuario.NEXTVAL;
  END IF;
END;
/


-- -------------------------------------------------------------
-- CATEGORIA
-- -------------------------------------------------------------
CREATE TABLE CATEGORIA (
  id_categoria INTEGER      NOT NULL,
  nm_categoria VARCHAR2(50) NOT NULL,
  CONSTRAINT pk_categoria PRIMARY KEY (id_categoria)
);

CREATE OR REPLACE TRIGGER trg_categoria_bi
BEFORE INSERT ON CATEGORIA FOR EACH ROW
BEGIN
  IF :NEW.id_categoria IS NULL THEN
    :NEW.id_categoria := sq_categoria.NEXTVAL;
  END IF;
END;
/


-- -------------------------------------------------------------
-- PROJETO
-- -------------------------------------------------------------
CREATE TABLE PROJETO (
  id_projeto         INTEGER        NOT NULL,
  id_usuario         INTEGER        NOT NULL,
  id_categoria       INTEGER        NOT NULL,
  nm_projeto         VARCHAR2(100)  NOT NULL,
  ds_projeto         VARCHAR2(255),
  st_projeto         VARCHAR2(16)   DEFAULT 'rascunho' NOT NULL,
  dt_criacao         DATE           DEFAULT SYSDATE    NOT NULL,
  dt_atualizacao     DATE           DEFAULT SYSDATE    NOT NULL,
  CONSTRAINT pk_projeto      PRIMARY KEY (id_projeto),
  CONSTRAINT fk_proj_usuario FOREIGN KEY (id_usuario)   REFERENCES USUARIO(id_usuario),
  CONSTRAINT fk_proj_categ   FOREIGN KEY (id_categoria) REFERENCES CATEGORIA(id_categoria),
  CONSTRAINT chk_st_projeto  CHECK (st_projeto IN ('publico', 'privado', 'rascunho'))
);

CREATE INDEX idx_projeto_usuario   ON PROJETO (id_usuario);
CREATE INDEX idx_projeto_categoria ON PROJETO (id_categoria);

CREATE OR REPLACE TRIGGER trg_projeto_bi
BEFORE INSERT ON PROJETO FOR EACH ROW
BEGIN
  IF :NEW.id_projeto IS NULL THEN
    :NEW.id_projeto := sq_projeto.NEXTVAL;
  END IF;
END;
/

-- Atualiza dt_atualizacao automaticamente a cada UPDATE
CREATE OR REPLACE TRIGGER trg_projeto_bu
BEFORE UPDATE ON PROJETO FOR EACH ROW
BEGIN
  :NEW.dt_atualizacao := SYSDATE;
END;
/


-- -------------------------------------------------------------
-- MIDIA
-- -------------------------------------------------------------
CREATE TABLE MIDIA (
  id_midia    INTEGER        NOT NULL,
  id_projeto  INTEGER        NOT NULL,
  tp_midia    VARCHAR2(16)   NOT NULL,
  nm_url      VARCHAR2(200)  NOT NULL,
  dt_criacao  DATE           DEFAULT SYSDATE NOT NULL,
  CONSTRAINT pk_midia      PRIMARY KEY (id_midia),
  CONSTRAINT fk_midia_proj FOREIGN KEY (id_projeto) REFERENCES PROJETO(id_projeto),
  CONSTRAINT chk_tp_midia  CHECK (tp_midia IN ('imagem', 'video', 'audio', 'texto'))
);

CREATE INDEX idx_midia_projeto ON MIDIA (id_projeto);

CREATE OR REPLACE TRIGGER trg_midia_bi
BEFORE INSERT ON MIDIA FOR EACH ROW
BEGIN
  IF :NEW.id_midia IS NULL THEN
    :NEW.id_midia := sq_midia.NEXTVAL;
  END IF;
END;
/


-- -------------------------------------------------------------
-- COMENTARIO
-- -------------------------------------------------------------
CREATE TABLE COMENTARIO (
  id_comentario INTEGER        NOT NULL,
  id_usuario    INTEGER        NOT NULL,
  id_projeto    INTEGER        NOT NULL,
  ds_comentario VARCHAR2(140)  NOT NULL,
  dt_criacao    DATE           DEFAULT SYSDATE NOT NULL,
  CONSTRAINT pk_comentario      PRIMARY KEY (id_comentario),
  CONSTRAINT fk_coment_usuario  FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario),
  CONSTRAINT fk_coment_projeto  FOREIGN KEY (id_projeto) REFERENCES PROJETO(id_projeto)
);

CREATE INDEX idx_comentario_projeto ON COMENTARIO (id_projeto);
CREATE INDEX idx_comentario_usuario ON COMENTARIO (id_usuario);

CREATE OR REPLACE TRIGGER trg_comentario_bi
BEFORE INSERT ON COMENTARIO FOR EACH ROW
BEGIN
  IF :NEW.id_comentario IS NULL THEN
    :NEW.id_comentario := sq_comentario.NEXTVAL;
  END IF;
END;
/


-- -------------------------------------------------------------
-- PROJETO_TAG  (associativa N:M — PK composta, sem sequence)
-- -------------------------------------------------------------
CREATE TABLE PROJETO_TAG (
  id_projeto INTEGER NOT NULL,
  id_tag     INTEGER NOT NULL,
  CONSTRAINT pk_projeto_tag   PRIMARY KEY (id_projeto, id_tag),
  CONSTRAINT fk_ptag_projeto  FOREIGN KEY (id_projeto) REFERENCES PROJETO(id_projeto),
  CONSTRAINT fk_ptag_tag      FOREIGN KEY (id_tag)     REFERENCES TAG(id_tag)
);

CREATE INDEX idx_ptag_projeto ON PROJETO_TAG (id_projeto);
CREATE INDEX idx_ptag_tag     ON PROJETO_TAG (id_tag);


-- -------------------------------------------------------------
-- CURTIDA  (associativa com atributo dt_criacao — PK composta)
-- -------------------------------------------------------------
CREATE TABLE CURTIDA (
  id_projeto  INTEGER NOT NULL,
  id_usuario  INTEGER NOT NULL,
  dt_criacao  DATE    DEFAULT SYSDATE NOT NULL,
  CONSTRAINT pk_curtida      PRIMARY KEY (id_projeto, id_usuario),
  CONSTRAINT fk_curt_projeto FOREIGN KEY (id_projeto) REFERENCES PROJETO(id_projeto),
  CONSTRAINT fk_curt_usuario FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario)
);

CREATE INDEX idx_curtida_projeto ON CURTIDA (id_projeto);
CREATE INDEX idx_curtida_usuario ON CURTIDA (id_usuario);


-- -------------------------------------------------------------
-- SALVO  (associativa com atributo dt_criacao — PK composta)
-- -------------------------------------------------------------
CREATE TABLE SALVO (
  id_usuario  INTEGER NOT NULL,
  id_projeto  INTEGER NOT NULL,
  dt_criacao  DATE    DEFAULT SYSDATE NOT NULL,
  CONSTRAINT pk_salvo      PRIMARY KEY (id_usuario, id_projeto),
  CONSTRAINT fk_salvo_usuario FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario),
  CONSTRAINT fk_salvo_projeto FOREIGN KEY (id_projeto) REFERENCES PROJETO(id_projeto)
);

CREATE INDEX idx_salvo_usuario ON SALVO (id_usuario);
CREATE INDEX idx_salvo_projeto ON SALVO (id_projeto);


-- =============================================================
-- FIM DO DDL
-- =============================================================
