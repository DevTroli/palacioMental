CREATE OR REPLACE TRIGGER trg_tag_bi
BEFORE INSERT ON TAG FOR EACH ROW
BEGIN
  IF :NEW.id_tag IS NULL THEN
    :NEW.id_tag := sq_tag.NEXTVAL;
  END IF;
END;
/

CREATE OR REPLACE TRIGGER trg_usuario_bi
BEFORE INSERT ON USUARIO FOR EACH ROW
BEGIN
  IF :NEW.id_usuario IS NULL THEN
    :NEW.id_usuario := sq_usuario.NEXTVAL;
  END IF;
END;
/

CREATE OR REPLACE TRIGGER trg_categoria_bi
BEFORE INSERT ON CATEGORIA FOR EACH ROW
BEGIN
  IF :NEW.id_categoria IS NULL THEN
    :NEW.id_categoria := sq_categoria.NEXTVAL;
  END IF;
END;
/
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

CREATE OR REPLACE TRIGGER trg_midia_bi
BEFORE INSERT ON MIDIA FOR EACH ROW
BEGIN
  IF :NEW.id_midia IS NULL THEN
    :NEW.id_midia := sq_midia.NEXTVAL;
  END IF;
END;
/

CREATE OR REPLACE TRIGGER trg_comentario_bi
BEFORE INSERT ON COMENTARIO FOR EACH ROW
BEGIN
  IF :NEW.id_comentario IS NULL THEN
    :NEW.id_comentario := sq_comentario.NEXTVAL;
  END IF;
END;
/


