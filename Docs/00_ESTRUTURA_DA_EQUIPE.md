# 👥 Estrutura da Equipe - Projeto Biblioteca FATEC

> **Propósito deste documento:** Ajudar a equipe de 6 pessoas a se organizar de forma que todos possam trabalhar em paralelo sem conflitos.

---

## 🏗️ Proposta de Atribuições (6 pessoas)

### 1. Tech Lead 

**Responsabilidades principais:**
- Define e documenta a arquitetura do sistema (camadas, fluxo de dados, padrões)
- Resolve conflitos técnicos quando duas pessoas têm abordagens diferentes
- Faz code review das partes críticas (autenticação, integração banco-backend)
- Garante que há documentação técnica suficiente para os outros seguirem
- É o "desempacador" - quando alguém está travado em um problema técnico, ajuda a destrancar

**Habilidades importantes:**
- Curiosidade técnica (gosta de pesquisar soluções)
- Capacidade de abstrair problemas (ver o "big picture")
- Boa comunicação (precisa explicar decisões técnicas para o resto da equipe)

---

### 2. Backend Lead

**Responsabilidades principais:**
- Desenvolve os controllers (endpoints da API)
- Implementa os services (lógica de negócio)
- Define os DTOs (Data Transfer Objects - estruturas de dados que trafegam pela API)
- Integra com o banco de dados
- Documenta a API (quais endpoints existem, o que cada um faz, exemplos de requisição/resposta)

**Habilidades importantes:**
- Confortável com orientação a objetos
- Entendimento de arquitetura em camadas (controller → service → repository)
- Atenção a edge cases (o que acontece se o usuário enviar dados inválidos?)

---

### 3. Database Lead

**Responsabilidades principais:**
- Cria os diagramas conceituais, lógicos e físicos do banco de dados
- Escreve os scripts DDL (CREATE TABLE) com todas as constraints
- Define índices estratégicos para performance
- Cria views úteis para queries comuns
- Documenta o schema (dicionário de dados explicando cada tabela e campo)
- Popula dados de seed para desenvolvimento e testes

**Habilidades importantes:**
- Entendimento de normalização (1NF, 2NF, 3NF)
- Pensamento analítico (consegue modelar relacionamentos complexos)
- Atenção a integridade referencial (foreign keys, cascades)

---

### 4. Frontend Lead

**Responsabilidades principais:**
- Traduz designs do Figma em FronEnd
- Define a estrutura de pastas e organização de componentes
- Implementa navegação dos paths
- Integra com a API do backend
- Gerencia estado da aplicação
- Garante responsividade (funciona em mobile e desktop)
- Implementa validações de formulário

**Habilidades importantes:**
- HTML, CSS, JavaScript sólidos
- Outra tecnologia não decidida
- Noção de UX (experiência do usuário)
- Atenção a detalhes visuais

---

### 5. UI/UX Designer

**Responsabilidades principais:**
- Cria wireframes (esboços de baixa fidelidade das telas)
- Desenvolve protótipos no Figma com todas as telas principais
- Cria guia de estilo (design system) para consistência
- Pensa nos estados das interfaces (vazio, carregando, erro, sucesso)
- Pode ajudar com iconografia e ilustrações
- Testa usabilidade com usuários beta e coleta feedback

**Habilidades importantes:**
- Familiaridade com Figma
- Senso estético (noção de cores, espaçamentos, proporções)
- Comunicação visual

---

### 6. DevOps

**Responsabilidades principais:**
- Configura o repositório GitHub (branches, proteções, CI/CD)
- Define e documenta o fluxo de trabalho (como criar branches, como fazer PRs)
- Configura ambientes (desenvolvimento, staging, produção)
- Faz deploy do backend (pode ser Heroku, Railway, Render)
- Faz deploy do frontend
- Configura banco de dados em produção (NeonDB)
- Implementa health check e status page
- Configura ferramentas de monitoramento e logs
- Pode configurar GitHub Actions para testes automáticos

**Habilidades importantes:**
- Entendimento de Git (branches, merges, rebases)
- Noção de redes e deploy (o que é um servidor, como funciona DNS, etc)
- Capacidade de debugar problemas de ambiente

---

### 7. Product Owner / Documentação Lead

**Responsabilidades principais:**
- Faz pesquisa com alunos (entrevistas, questionários) para entender necessidades
- Define e prioriza funcionalidades (o que entra no PoC vs MVP vs futuro)
- Escreve user stories e critérios de aceitação
- Mantém o backlog organizado (issues do GitHub)
- Documenta decisões importantes da equipe
- Escreve a documentação ABNT do projeto
- Prepara slides para apresentação final
- Coordena testes com usuários beta e coleta feedback
- Calcula e apresenta métricas de uso
- Cria relatórios de progresso para os professores (se necessário)

**Habilidades importantes:**
- Excelente comunicação escrita
- Organização (mantém muitos documentos e informações organizados)
- Empatia (entende necessidades dos usuários)
- Capacidade de priorização (o que é mais importante agora?)

---

**Data da última atualização:** 19/02/2026
**Revisão necessária:** 26/02/2026
