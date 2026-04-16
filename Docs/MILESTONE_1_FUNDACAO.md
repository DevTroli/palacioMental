# 🏗️ Milestone 1 — Fundação: Banco de Dados
**Palácio Mental · Projeto Integrador · Engenharia de Software · Fatec Praia Grande**
> Status: 🔄 Em andamento · Período: Abril/2026 · Responsável:  Troli

---

## Objetivo

Entregar a fundação do banco de dados do Palácio Mental no Oracle: modelo conceitual, modelo lógico, scripts DDL com todas as constraints e documentação formal — base sobre a qual as fases 2, 3 e 4 serão construídas.

---

## Entidades

### Central
| Entidade | Por quê |
|---|---|
| PROJETO | Pivot do sistema — tudo gira em torno de projetos publicados |

### Fortes (independentes)
| Entidade | Descrição |
|---|---|
| USUARIO | Criadores da plataforma |
| CATEGORIA | Classificação principal dos projetos |
| TAG | Palavras-chave livres para descoberta |

### Fracas (dependentes)
| Entidade | Depende de |
|---|---|
| COMENTARIO | PROJETO + USUARIO |
| MIDIA | PROJETO |

### Associativas (N:M)
| Tabela | Resolve |
|---|---|
| PROJETO_TAG | PROJETO ↔ TAG |
| CURTIDA | USUARIO ↔ PROJETO — curte |
| SALVO | USUARIO ↔ PROJETO — salva |

---

## Relacionamentos

| Relacionamento | Cardinalidade | Descrição |
|---|---|---|
| USUARIO → PROJETO | 1:N | Um usuário publica vários projetos |
| CATEGORIA → PROJETO | 1:N | Uma categoria classifica vários projetos |
| PROJETO ↔ TAG | N:M | Via PROJETO_TAG |
| USUARIO → COMENTARIO | 1:N | Um usuário escreve vários comentários |
| PROJETO → COMENTARIO | 1:N | Um projeto recebe vários comentários |
| PROJETO → MIDIA | 1:N | Um projeto contém vários arquivos de mídia |
| USUARIO ↔ PROJETO | N:M | Via CURTIDA e via SALVO |

---

## Regras de Negócio

| Código | Regra | Como |
|---|---|---|
| RN01 | Todo projeto tem um único autor | FK NOT NULL |
| RN02 | Username e e-mail únicos | UNIQUE constraint |
| RN03 | Status: só rascunho, publicado ou arquivado | CHECK constraint |
| RN04 | Curtida única por usuário/projeto | UNIQUE(projeto_id, usuario_id) |
| RN05 | Salvo único por usuário/projeto | UNIQUE(projeto_id, usuario_id) |
| RN06 | Tag não duplicada por projeto | PK composta em PROJETO_TAG |
| RN07 | Tipo de mídia restrito | CHECK IN ('imagem','video','link') |
| RN08 | Comentário não pode ser vazio | NOT NULL |
| RN09 | Excluir projeto remove dependentes | ON DELETE CASCADE |
| RN10 | Senha nunca em texto puro | Hash na camada de aplicação |

---

## Requisitos Funcionais — escopo atual

| Código | Requisito | Entidade(s) envolvida(s) |
|---|---|---|
| RF01 | Cadastro e autenticação de usuários | USUARIO |
| RF02 | Publicação de projetos | PROJETO, CATEGORIA |
| RF03 | Feed público de projetos | PROJETO, USUARIO |
| RF04 | Perfil do usuário | USUARIO, PROJETO |
| RF05 | Curtidas e salvos | CURTIDA, SALVO |
| RF06 | Comentários em projetos | COMENTARIO |
| RF07 | Categorias e tags | CATEGORIA, TAG, PROJETO_TAG |
| RF08 | Busca básica | PROJETO, TAG, CATEGORIA |

---

## Organização dos scripts

```
database/
├── migrations/
│   ├── sequences/
│   │   └── V001__sequences.sql
│   ├── tables/
│   │   ├── V010__create_usuario.sql
│   │   └── ... (demais tabelas)
│   └── triggers/
│       └── V020__triggers.sql
├── plsql/  
│   ├── functions/
│   │   └── fn_contar_curtidas.sql
│   ├── procedures/
│   │   └── prc_processar_rascunhos.sql
│   └── packages/
│       ├── pkg_projeto_spec.sql    ← especificação (interface pública)
│       └── pkg_projeto_body.sql    ← corpo (implementação)
├── queries/
│   ├── joins_feed.sql
│   ├── joins_perfil.sql
│   └── subconsultas.sql
├── seeds/
│   ├── seed_categorias.sql
│   ├── seed_tags.sql
│   └── seed_dev.sql
└── docs/
    ├── modelo_conceitual.png
    ├── modelo_logico.png
    └── dicionario_de_dados.md
```

---

## O que vem a seguir

Esta fase entrega a fundação. As próximas fases constroem em cima:

- **Fase 2 — Backend:** API REST consome as tabelas criadas aqui. Endpoints para todas as entidades.
- **Fase 3 — Frontend:** Interface lê a API. As 4 telas mapeiam diretamente as entidades principais.
- **Fase 4 — DevOps:** Todo o stack containerizado. Oracle roda em container junto com backend e frontend.

---

## ✅ Checklist de conclusão

- [X] Modelo conceitual (DER) criado e validado
- [X] Modelo lógico (tabelas + FKs + tipos) definido
- [X] Regras de negócio documentadas
- [x] Documentação ABNT — rascunho entregue
- [ ] Scripts DDL Oracle escritos e testados
- [ ] Constraints e índices aplicados e validados
- [ ] Dados de seed inseridos
- [ ] Documentação ABNT — versão final
