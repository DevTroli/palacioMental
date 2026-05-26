CREATE TABLE COMENTARIO (
  id_comentario INTEGER        NOT NULL,
  id_usuario    INTEGER        NOT NULL,
  id_projeto    INTEGER        NOT NULL,
  ds_comentario VARCHAR2(600)  NOT NULL,
  dt_criacao    DATE           DEFAULT SYSDATE NOT NULL,
  CONSTRAINT pk_comentario      PRIMARY KEY (id_comentario),
  CONSTRAINT fk_coment_usuario  FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario),
  CONSTRAINT fk_coment_projeto  FOREIGN KEY (id_projeto) REFERENCES PROJETO(id_projeto)
);

CREATE INDEX idx_comentario_projeto ON COMENTARIO (id_projeto);
CREATE INDEX idx_comentario_usuario ON COMENTARIO (id_usuario);
