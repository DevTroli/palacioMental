CREATE TABLE MIDIA (
  id_midia    INTEGER        NOT NULL,
  id_projeto  INTEGER        NOT NULL,
  tp_midia    VARCHAR2(16)   NOT NULL,
  url_midia   VARCHAR2(600)  NOT NULL,
  dt_criacao  DATE           DEFAULT SYSDATE NOT NULL,
  CONSTRAINT pk_midia      PRIMARY KEY (id_midia),
  CONSTRAINT fk_midia_proj FOREIGN KEY (id_projeto) REFERENCES PROJETO(id_projeto),
  CONSTRAINT chk_tp_midia  CHECK (tp_midia IN ('imagem', 'video', 'audio', 'texto'))
);

CREATE INDEX idx_midia_projeto ON MIDIA (id_projeto);
