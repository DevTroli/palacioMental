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
