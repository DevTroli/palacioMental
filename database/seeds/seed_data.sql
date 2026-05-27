-- ============================================================
-- Palácio Mental — Seed Data (Oracle)
-- Dados de demonstração para desenvolvimento e testes
-- 5 categorias, 10 tags, 6 usuários, 10 projetos
-- ============================================================

-- Sequências devem estar criadas antes deste script.
-- IDs usam sq_*.NEXTVAL para respeitar as sequences.

-- -----------------------------------------------------------
-- 5 Categorias
-- -----------------------------------------------------------
INSERT INTO CATEGORIA (id_categoria, nm_categoria) VALUES (sq_categoria.NEXTVAL, 'Desenvolvimento Web');
INSERT INTO CATEGORIA (id_categoria, nm_categoria) VALUES (sq_categoria.NEXTVAL, 'Banco de Dados');
INSERT INTO CATEGORIA (id_categoria, nm_categoria) VALUES (sq_categoria.NEXTVAL, 'Mobile');
INSERT INTO CATEGORIA (id_categoria, nm_categoria) VALUES (sq_categoria.NEXTVAL, 'Inteligência Artificial');
INSERT INTO CATEGORIA (id_categoria, nm_categoria) VALUES (sq_categoria.NEXTVAL, 'DevOps');

-- -----------------------------------------------------------
-- 10 Tags
-- -----------------------------------------------------------
INSERT INTO TAG (id_tag, nm_tag) VALUES (sq_tag.NEXTVAL, 'react');
INSERT INTO TAG (id_tag, nm_tag) VALUES (sq_tag.NEXTVAL, 'laravel');
INSERT INTO TAG (id_tag, nm_tag) VALUES (sq_tag.NEXTVAL, 'oracle');
INSERT INTO TAG (id_tag, nm_tag) VALUES (sq_tag.NEXTVAL, 'api');
INSERT INTO TAG (id_tag, nm_tag) VALUES (sq_tag.NEXTVAL, 'flutter');
INSERT INTO TAG (id_tag, nm_tag) VALUES (sq_tag.NEXTVAL, 'python');
INSERT INTO TAG (id_tag, nm_tag) VALUES (sq_tag.NEXTVAL, 'docker');
INSERT INTO TAG (id_tag, nm_tag) VALUES (sq_tag.NEXTVAL, 'tailwind');
INSERT INTO TAG (id_tag, nm_tag) VALUES (sq_tag.NEXTVAL, 'sql');
INSERT INTO TAG (id_tag, nm_tag) VALUES (sq_tag.NEXTVAL, 'machine-learning');

-- -----------------------------------------------------------
-- 6 Usuários
-- Senhas: hash bcrypt de 'password' → $2y$12$...
-- -----------------------------------------------------------
INSERT INTO USUARIO (id_usuario, nm_usuario, nm_email_usuario, cd_senha_usuario, nm_apelido_usuario, ds_bio_usuario, avatar_url)
VALUES (sq_usuario.NEXTVAL, 'Pablo Troli', 'troli@fatec.sp.edu.br', '$2y$12$YWJjZGVmZ2hpamtsbW5vcHFyc3R1dnd4eXoxMjM0NTY', 'troli', 'Tech Lead e DBA do Palácio Mental. Apaixonado por Oracle e Laravel.', NULL);

INSERT INTO USUARIO (id_usuario, nm_usuario, nm_email_usuario, cd_senha_usuario, nm_apelido_usuario, ds_bio_usuario, avatar_url)
VALUES (sq_usuario.NEXTVAL, 'Felipe Santos', 'felipe@fatec.sp.edu.br', '$2y$12$YWJjZGVmZ2hpamtsbW5vcHFyc3R1dnd4eXoxMjM0NTY', 'felipe', 'Desenvolvedor backend focado em PHP e APIs REST.', NULL);

INSERT INTO USUARIO (id_usuario, nm_usuario, nm_email_usuario, cd_senha_usuario, nm_apelido_usuario, ds_bio_usuario, avatar_url)
VALUES (sq_usuario.NEXTVAL, 'Eduardo Lima', 'eduardo@fatec.sp.edu.br', '$2y$12$YWJjZGVmZ2hpamtsbW5vcHFyc3R1dnd4eXoxMjM0NTY', 'eduardo', 'Backend developer explorando microserviços e mensageria.', NULL);

INSERT INTO USUARIO (id_usuario, nm_usuario, nm_email_usuario, cd_senha_usuario, nm_apelido_usuario, ds_bio_usuario, avatar_url)
VALUES (sq_usuario.NEXTVAL, 'Iago Oliveira', 'iago@fatec.sp.edu.br', '$2y$12$YWJjZGVmZ2hpamtsbW5vcHFyc3R1dnd4eXoxMjM0NTY', 'iago', 'Frontend developer entusiasta de Vue e Livewire.', NULL);

INSERT INTO USUARIO (id_usuario, nm_usuario, nm_email_usuario, cd_senha_usuario, nm_apelido_usuario, ds_bio_usuario, avatar_url)
VALUES (sq_usuario.NEXTVAL, 'Yohan Ferreira', 'yohan@fatec.sp.edu.br', '$2y$12$YWJjZGVmZ2hpamtsbW5vcHFyc3R1dnd4eXoxMjM0NTY', 'yohan', 'Designer UX/UI — transformando ideias em interfaces intuitivas.', NULL);

INSERT INTO USUARIO (id_usuario, nm_usuario, nm_email_usuario, cd_senha_usuario, nm_apelido_usuario, ds_bio_usuario, avatar_url)
VALUES (sq_usuario.NEXTVAL, 'Matheus Costa', 'matheus@fatec.sp.edu.br', '$2y$12$YWJjZGVmZ2hpamtsbW5vcHFyc3R1dnd4eXoxMjM0NTY', 'matheus', 'DevOps e documentação. Docker, CI/CD e tudo entre código e produção.', NULL);

-- -----------------------------------------------------------
-- 10 Projetos
-- IDs de referência assumem sequenciais a partir de 1:
--   categorias: 1=DevWeb, 2=BD, 3=Mobile, 4=IA, 5=DevOps
--   usuarios:   1=Troli, 2=Felipe, 3=Eduardo, 4=Iago, 5=Yohan, 6=Matheus
-- -----------------------------------------------------------
INSERT INTO PROJETO (id_projeto, id_usuario, id_categoria, nm_projeto, ds_projeto, st_projeto)
VALUES (sq_projeto.NEXTVAL, 1, 1, 'Palácio Mental', 'Plataforma de compartilhamento de projetos acadêmicos desenvolvida com Laravel, Livewire e Oracle. Projeto integrador da Fatec Praia Grande — DSM 2026.', 'publico');

INSERT INTO PROJETO (id_projeto, id_usuario, id_categoria, nm_projeto, ds_projeto, st_projeto)
VALUES (sq_projeto.NEXTVAL, 2, 1, 'API REST de Tarefas', 'API RESTful para gerenciamento de tarefas com autenticação JWT, CRUD completo e documentação Swagger. Desenvolvida em Laravel 12.', 'publico');

INSERT INTO PROJETO (id_projeto, id_usuario, id_categoria, nm_projeto, ds_projeto, st_projeto)
VALUES (sq_projeto.NEXTVAL, 3, 2, 'Migrador de Dados', 'Ferramenta PL/SQL para migração de dados entre schemas Oracle com logs de execução, rollback automático e relatório de inconsistências.', 'publico');

INSERT INTO PROJETO (id_projeto, id_usuario, id_categoria, nm_projeto, ds_projeto, st_projeto)
VALUES (sq_projeto.NEXTVAL, 4, 3, 'App de Eventos Acadêmicos', 'Aplicativo mobile em Flutter para divulgação e inscrição em eventos da Fatec. Notificações push, agenda e QR code de check-in.', 'publico');

INSERT INTO PROJETO (id_projeto, id_usuario, id_categoria, nm_projeto, ds_projeto, st_projeto)
VALUES (sq_projeto.NEXTVAL, 1, 4, 'Classificador de Sentimentos', 'Modelo de NLP para classificação de sentimentos em reviews de produtos. Treinado com Python, scikit-learn e dataset B2W-Reviews.', 'publico');

INSERT INTO PROJETO (id_projeto, id_usuario, id_categoria, nm_projeto, ds_projeto, st_projeto)
VALUES (sq_projeto.NEXTVAL, 6, 5, 'Pipeline CI/CD com GitHub Actions', 'Configuração de pipeline completo de integração e entrega contínua: build, testes, lint, deploy automatizado em VPS com Docker.', 'publico');

INSERT INTO PROJETO (id_projeto, id_usuario, id_categoria, nm_projeto, ds_projeto, st_projeto)
VALUES (sq_projeto.NEXTVAL, 5, 1, 'Design System Fatec', 'Sistema de design com componentes Figma exportados para Tailwind CSS. Tokens de cor, tipografia e espaçamento padronizados.', 'publico');

INSERT INTO PROJETO (id_projeto, id_usuario, id_categoria, nm_projeto, ds_projeto, st_projeto)
VALUES (sq_projeto.NEXTVAL, 2, 2, 'Dashboard de Performance Oracle', 'Painel web para monitoramento de queries lentas, sessões ativas e tablespace usage em instâncias Oracle XE. Atualização em tempo real via Livewire.', 'rascunho');

INSERT INTO PROJETO (id_projeto, id_usuario, id_categoria, nm_projeto, ds_projeto, st_projeto)
VALUES (sq_projeto.NEXTVAL, 3, 4, 'Recomendador de Projetos', 'Motor de recomendação baseado em tags e categorias. Algoritmo de similaridade de cosseno sobre vetores TF-IDF dos projetos.', 'rascunho');

INSERT INTO PROJETO (id_projeto, id_usuario, id_categoria, nm_projeto, ds_projeto, st_projeto)
VALUES (sq_projeto.NEXTVAL, 4, 1, 'Portfolio Pessoal', 'Site portfolio com Livewire e Tailwind. Seções: sobre, projetos, contato. Formulário de mensagem integrado com mail trap.', 'privado');

-- -----------------------------------------------------------
-- Projetos ↔ Tags  (projeto_tag)
-- Projetos 1–10 referenciam IDs sequenciais 1–10
-- Tags 1–10: react, laravel, oracle, api, flutter, python, docker, tailwind, sql, machine-learning
-- -----------------------------------------------------------
-- Projeto 1: Palácio Mental → laravel, oracle, tailwind
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (1, 2);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (1, 3);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (1, 8);

-- Projeto 2: API REST de Tarefas → laravel, api
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (2, 2);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (2, 4);

-- Projeto 3: Migrador de Dados → oracle, sql
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (3, 3);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (3, 9);

-- Projeto 4: App de Eventos → flutter, api
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (4, 5);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (4, 4);

-- Projeto 5: Classificador de Sentimentos → python, machine-learning
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (5, 6);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (5, 10);

-- Projeto 6: Pipeline CI/CD → docker
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (6, 7);

-- Projeto 7: Design System Fatec → tailwind, react
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (7, 8);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (7, 1);

-- Projeto 8: Dashboard Oracle → oracle, laravel, sql
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (8, 3);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (8, 2);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (8, 9);

-- Projeto 9: Recomendador → python, machine-learning, api
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (9, 6);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (9, 10);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (9, 4);

-- Projeto 10: Portfolio Pessoal → laravel, tailwind
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (10, 2);
INSERT INTO PROJETO_TAG (id_projeto, id_tag) VALUES (10, 8);

COMMIT;
