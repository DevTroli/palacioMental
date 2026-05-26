CREATE TABLE PROJETO_TAG (
  id_projeto INTEGER NOT NULL,
  id_tag     INTEGER NOT NULL,
  CONSTRAINT pk_projeto_tag   PRIMARY KEY (id_projeto, id_tag),
  CONSTRAINT fk_ptag_projeto  FOREIGN KEY (id_projeto) REFERENCES PROJETO(id_projeto),
  CONSTRAINT fk_ptag_tag      FOREIGN KEY (id_tag)     REFERENCES TAG(id_tag)
);

CREATE INDEX idx_ptag_projeto ON PROJETO_TAG (id_projeto);
CREATE INDEX idx_ptag_tag     ON PROJETO_TAG (id_tag);
