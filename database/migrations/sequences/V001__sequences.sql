-- =============================================================
-- PALACIO MENTAL — Sequences
-- Versão : V001
-- Descrição: Contadores automáticos de PK para cada tabela
--            com identificador surrogate
-- Depende de: nada
-- =============================================================

CREATE SEQUENCE sq_tag       START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE SEQUENCE sq_usuario   START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE SEQUENCE sq_categoria START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE SEQUENCE sq_projeto   START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE SEQUENCE sq_midia     START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE SEQUENCE sq_comentario START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
