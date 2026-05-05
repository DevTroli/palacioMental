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
