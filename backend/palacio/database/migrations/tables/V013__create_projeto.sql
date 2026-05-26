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
