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
