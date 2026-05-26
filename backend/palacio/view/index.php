<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palácio Mental - Home</title>
    <link rel="stylesheet" href="../css/home-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    <div class="dashboard-container">
        
        <aside class="sidebar">
            <div class="brand">
                <img src="../img/logo-mindpalace.png" alt="Logo">
                <div class="brand-text">
                    <span class="brand-title">PALÁCIO</span>
                    <span class="brand-subtitle">MENTAL</span>
                </div>
            </div>

            <nav class="sidebar-menu">
                <a href="#" class="menu-item active"><i data-lucide="home"></i> Home</a>
                <a href="#" class="menu-item"><i data-lucide="message-square"></i> Mensagens</a>
                <a href="#" class="menu-item"><i data-lucide="bell"></i> Notificações</a>
                <a href="#" class="menu-item"><i data-lucide="bookmark"></i> Salvos</a>

                <div class="menu-section-title">SUAS COLEÇÕES</div>
                <a href="meus-projetos.php" class="menu-item"><i data-lucide="folder-open"></i> Projetos em Andamento</a>
                <a href="#" class="menu-item"><i data-lucide="check-square"></i> Finalizados</a>
            </nav>

            <div class="sidebar-footer">
                <div class="upgrade-card" style="margin-bottom: 20px;">
                    <div class="upgrade-header">
                        <span>Upgrade para Pro</span>
                        <i data-lucide="crown" class="crown-icon"></i>
                    </div>
                    <p>Recursos ilimitados, equipes e mais benefícios.</p>
                    <button class="btn-upgrade">Ver Planos</button>
                </div>
                <a href="#" class="menu-item logout-btn" onclick="logout()">
                    <i data-lucide="log-out"></i>
                    Sair da Conta
                </a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="top-nav">
                    <a href="#" class="nav-link active">Início</a>
                    <a href="#" class="nav-link">Explorar</a>
                    <a href="busca-projetos.php" class="nav-link">Projetos</a>
                    <a href="#" class="nav-link">Pessoas</a>
                    <a href="#" class="nav-link">Comunidades</a>
                </div>
                <div class="top-actions">
                    <div class="search-box">
                        <i data-lucide="search"></i>
                        <input type="text" placeholder="Buscar projetos, pessoas, tags...">
                    </div>
                    <a href="criar-projeto.php" style="text-decoration: none;"><button class="btn-new-project"><i data-lucide="plus"></i> Novo Projeto</button></a>
                    
                    <img src="../img/user1.jpeg" alt="Avatar" class="user-avatar" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                </div>
            </header>

            <section class="welcome-section">
                <h1>Bem-vindo de volta, <span id="userName"><?php echo $userName; ?></span>! 👋</h1>
                <p>Aqui é onde ideias ganham vida e conexões criam o impossível.</p>
            </section>

            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon icon-purple"><i data-lucide="folder"></i></div>
                    <div class="stat-info">
                        <h3>12</h3>
                        <p>Projetos <span>4 ativos</span></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-orange"><i data-lucide="users"></i></div>
                    <div class="stat-info">
                        <h3>28</h3>
                        <p>Colaboradores <span>12 online</span></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-green"><i data-lucide="message-circle"></i></div>
                    <div class="stat-info">
                        <h3>46</h3>
                        <p>Feedbacks <span>8 novos</span></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-pink"><i data-lucide="heart"></i></div>
                    <div class="stat-info">
                        <h3>156</h3>
                        <p>Curtidas <span>+23 esta semana</span></p>
                    </div>
                </div>
            </section>

            <section class="projects-section">
                <div class="section-header">
                    <h2>Projetos Recentes</h2>
                    <a href="busca-projetos.php" class="view-all">Ver todos</a>
                </div>

                <div class="projects-grid">
                    <div class="project-card" onclick="openDetails('Vaudevilla', 'Projeto de Comic ficção científica')">
                        <div class="card-banner">
                            <img src="../img/project_1.png" alt="Vaudevilla">
                            <span class="badge badge-purple">Em andamento</span>
                        </div>
                        <div class="card-body">
                            <h3>Vaudevilla</h3>
                            <p>Projeto de Comic ficção científica</p>
                            <div class="card-footer">
                                <div class="avatar-group">
                                    <img src="../img/user1.jpeg" alt="u1">
                                    <img src="../img/user1.jpeg" alt="u2">
                                    <span class="more-avatars">+5</span>
                                </div>
                                <div class="comments-count"><i data-lucide="message-square"></i> 12</div>
                            </div>
                        </div>
                    </div>

                    <div class="project-card">
                        <div class="card-banner">
                            <img src="../img/project_3.jpeg" alt="Laravel">
                            <span class="badge badge-orange">Ideia</span>
                        </div>
                        <div class="card-body">
                            <h3>Projeto LARAVEL - </h3>
                            <p>Projeto de jogos de Boardgame</p>
                            <div class="card-footer">
                                <div class="avatar-group">
                                    <img src="../img/user1.jpeg" alt="u3">
                                    <img src="../img/user1.jpeg" alt="u4">
                                    <span class="more-avatars">+3</span>
                                </div>
                                <div class="comments-count"><i data-lucide="message-square"></i> 8</div>
                            </div>
                        </div>
                    </div>

                    <div class="project-card">
                        <div class="card-banner">
                            <img src="../img/project_5_sql.jpeg" alt="Eco">
                            <span class="badge badge-green">Ativo</span>
                        </div>
                        <div class="card-body">
                            <h3>Projeto Banco de dados SQL</h3>
                            <p>Projeto Semestral SQL</p>
                            <div class="card-footer">
                                <div class="avatar-group">
                                    <img src="../img/user1.jpeg" alt="u5">
                                    <img src="../img/user1.jpeg" alt="u6">
                                    <span class="more-avatars">+7</span>
                                </div>
                                <div class="comments-count"><i data-lucide="message-square"></i> 15</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

       <!--  <aside class="right-sidebar">
            <div class="right-box">
                <div class="box-header">
                    <h2>Encontre Colaboradores</h2>
                    <a href="#">Ver todos</a>
                </div>
                <div class="colab-list">
                    <div class="user-item">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100" alt="Lucas">
                        <div class="user-info">
                            <h4>Lucas Martins</h4>
                            <p>Designer UX/UI</p>
                        </div>
                        <button class="btn-connect">Conectar</button>
                    </div>
                    <div class="user-item">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="Marina">
                        <div class="user-info">
                            <h4>Marina Souza</h4>
                            <p>Roteirista</p>
                        </div>
                        <button class="btn-connect">Conectar</button>
                    </div>
                </div>
            </div>

            <div class="right-box">
                <div class="box-header">
                    <h2>Atividade Recente</h2>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <p><strong>Pedro</strong> comentou em <span class="txt-purple">Nebulosa</span></p>
                        <span class="time">há 2h</span>
                    </div>
                    <div class="activity-item">
                        <p><strong>Marina</strong> deu feedback em <span class="txt-purple">EcoHabit</span></p>
                        <span class="time">há 3h</span>
                    </div>
                </div>
                <a href="#" class="view-all-activity">Ver toda atividade</a>
            </div>

            <div class="tip-box">
                <div class="tip-title">
                    <i data-lucide="lightbulb"></i>
                    <span>Dica do dia</span>
                </div>
                <p>Compartilhe suas ideias com detalhes. Quanto mais claro, melhores colaborações!</p>
                <i data-lucide="x" class="close-tip"></i>
            </div>
        </aside>-->

    </div>

    <!-- Sidebar de detalhes -->
    <div id="detailsSidebar" style="position: fixed; top: 0; right: -400px; width: 400px; height: 100%; background: #f5f3ff; box-shadow: -5px 0 15px rgba(0,0,0,0.1); z-index: 2000; transition: right 0.3s; padding: 40px; overflow-y: auto;">
        <h2 id="sidebarTitle">Nome do Projeto</h2>
        <p id="sidebarDesc" style="margin: 20px 0; color: var(--text-muted);">Descrição aqui.</p>
        <h3>Colaboradores</h3>
        <div id="sidebarCollabs" class="collaborators"></div>
    </div>

    <script>
        lucide.createIcons();
        
        function openDetails(name, desc) {
            document.getElementById('sidebarTitle').innerText = name;
            document.getElementById('sidebarDesc').innerText = desc;
            document.getElementById('detailsSidebar').style.right = '0';
            event.stopPropagation();
        }
        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('detailsSidebar');
            if (!sidebar.contains(e.target)) sidebar.style.right = '-400px';
        });

        function logout() {
            window.location.href = 'login.php';
        }
    </script>
</body>
</html>