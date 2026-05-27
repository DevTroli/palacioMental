# DDL MySQL — Palácio Mental

Este diretório contém o DDL MySQL equivalente ao schema Oracle em `../palacio_mental.sql`.

As tabelas, FKs e constraints são **logicamente idênticas** entre Oracle e MySQL. O modelo de dados foi preservado fielmente — mesmas entidades, mesmos relacionamentos, mesmas regras de integridade.

## Diferenças técnicas Oracle → MySQL

| Oracle | MySQL | Nota |
|--------|-------|------|
| `SEQUENCE` + `TRIGGER` | `AUTO_INCREMENT` | Auto-incremento nativo elimina a necessidade de sequências e triggers de ID |
| `VARCHAR2(n)` | `VARCHAR(n)` | Tipo de string padrão do MySQL |
| `DATE` (com hora) | `DATETIME` | Oracle `DATE` inclui hora; MySQL `DATE` é só data, `DATETIME` equivale |
| `SYSDATE` | `CURRENT_TIMESTAMP` | Função de timestamp corrente |
| `VARCHAR2(4000)` | `LONGTEXT` | Para campos de descrição longa sem limite prático |
| `NUMBER` | `BIGINT` / `INT` | Tipos numéricos equivalentes |
| Trigger `trg_projeto_bu` | `ON UPDATE CURRENT_TIMESTAMP` | Atualização automática via definição de coluna |

## Mapeamento de tabelas

| Oracle | MySQL (Laravel convention) |
|--------|---------------------------|
| USUARIO | users |
| PROJETO | projetos |
| CATEGORIA | categorias |
| TAG | tags |
| COMENTARIO | comentarios |
| MIDIA | midias |
| CURTIDA | curtidas |
| SALVO | salvos |
| PROJETO_TAG | projeto_tag |

## Como usar

```bash
mysql -u root -p palacio_mental < palacio_mental_mysql.sql
```
