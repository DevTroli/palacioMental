# 🧠 Palácio Mental
### Rede Acadêmica de Compartilhamento de Projetos e Ideias

> **Trabalho Semestral — Engenharia de Software**
> **Fatec Praia Grande · Desenvolvimento de Software Multiplataforma · 2026**

---

## 🎯 Visão Geral

**"Um espaço onde ideias deixam de ser rascunho e passam a existir."**

O **Palácio Mental** é uma plataforma web de compartilhamento de projetos e ideias acadêmicas. Funciona como a fusão de um portfólio pessoal, rede social criativa e biblioteca de projetos — permitindo que estudantes publiquem, evoluam e compartilhem suas criações com a comunidade universitária.

**Escrever num pitch melhor para vender a ideia**

---

## 👥 Equipe

| Papel | Membro |
|---|---|
| Database Lead | Pablo Troli |
| Backend | Felipe Figueiredo |
| DevOps Lead | Matheus Fernandes |
| UI/UX Designer | Yohan Ruiz |
| Backend Lead | Eduardo Elias |
| FrontEnd Lead | Iago Sampaio |

---

## 📊 Status Atual

**Fase:** Milestone 1 — Fundação de Banco de Dados

| Entregável | Progresso |
|---|---|
| Modelo conceitual (DER) | ✅ 100% |
| Modelo lógico (tabelas e FKs) | ✅ 100% |
| DDL Oracle (CREATE TABLE) | 🔄 Em andamento |
| Dados de seed | 🔲 Pendente |
| Documentação ABNT | 🔄 Em andamento |

---

## 💡 Proposta de Valor

| Para quem | Dor atual | O que o Palácio Mental oferece |
|---|---|---|
| Estudante de tecnologia | Projetos ficam esquecidos após a entrega | Portfólio vivo, construído ao longo do curso |
| Estudante iniciante | Não sabe o que os colegas mais avançados estão fazendo | Feed de projetos por categoria e nível |
| Professor / orientador | Não tem visibilidade do progresso dos alunos fora da sala | Projetos públicos com histórico de atualizações |
| Recrutador / empresa | Dificuldade de encontrar talentos acadêmicos emergentes | Perfis com projetos reais, comentados pela comunidade |

---

## 🛠️ Stack Tecnológica

| Camada | Tecnologia |
|---|---|
| Banco de Dados | Oracle Database XE / Oracle Cloud |
| Backend | PHP/Laravel |
| Frontend | A definir |
| Design | Figma |
| DevOps | Docker + GitHub Actions |
| Hospedagem | Vercel (?)|

---

## 📁 Estrutura do Repositório

```
palacio-mental/
├── README.md
├── .gitignore
├── Docs/
│   ├── 00_ESTRUTURA_DA_EQUIPE.md
│   ├── GUIA_GITHUB_GESTAO.md
│   ├── MILESTONE_0_PLANEJAMENTO.md
│   └── MILESTONE_1_FUNDACAO.md
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
├── backend/
├── frontend/             # Stacke a definir (fase 3)
└── .github/
    ├── ISSUE_TEMPLATE/
    └── workflows/
```

---

## 🗃️ Modelagem de Banco de Dados

### Entidades principais

- **USUARIO** — perfis de criadores da plataforma
- **PROJETO** — ideias e trabalhos publicados (entidade central)
- **CATEGORIA** — classificação principal dos projetos
- **TAG** — palavras-chave livres para descoberta
- **COMENTARIO** — feedback da comunidade (entidade fraca)
- **MIDIA** — arquivos e links associados aos projetos (entidade fraca)
- **CURTIDA** — interação N:M entre USUARIO e PROJETO
- **SALVO** — curadoria pessoal N:M entre USUARIO e PROJETO
- **PROJETO_TAG** — tabela associativa N:M entre PROJETO e TAG

### Diagramas

- Modelo Conceitual: `/database/diagrams/modelo_conceitual.png`
- Modelo Lógico: `/database/diagrams/modelo_logico.png`
- Scripts DDL: `/database/migrations/`

---

## 🔧 Como Contribuir

1. Leia o `Docs/GUIA_GITHUB_GESTAO.md` antes de qualquer coisa
2. Pegue uma issue do board (GitHub Projects)
3. Crie uma branch: `feature/nome-da-feature`
4. Abra Pull Request para `develop` com pelo menos 1 aprovação
5. Nunca commite direto em `main`

---



---

**Coordenador:** Marcio Galvão · **Contato da equipe:** GitHub Issues / Discord
