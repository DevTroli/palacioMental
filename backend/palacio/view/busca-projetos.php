<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palácio Mental - Explorar Projetos</title>
    <link rel="stylesheet" href="../css/home-style.css">
    <link rel="stylesheet" href="../css/meus-projetos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .search-hero { padding: 20px; background: white; border-radius: 16px; margin-bottom: 24px; text-align: center; border: 1px solid var(--border-color); }
        .search-input { width: 100%; max-width: 600px; padding: 15px 25px; border-radius: 25px; border: 1px solid var(--border-color); margin-top: 20px; font-size: 1rem; outline: none; }
        .card-banner { height: 150px; background: #e2e8f0; border-radius: 12px; margin-bottom: 15px; overflow: hidden; }
        .card-banner img { width: 100%; height: 100%; object-fit: cover; }
        .collaborators { display: flex; margin-top: 10px; }
        .collab-thumb { width: 25px; height: 25px; border-radius: 50%; border: 2px solid white; margin-left: -8px; background: #ddd; }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="brand">
                <img src="../img/logo-mindpalace" alt="Logo">
                <div class="brand-text">
                    <span class="brand-title">PALÁCIO</span>
                    <span class="brand-subtitle">MENTAL</span>
                </div>
            </div>

            <nav class="sidebar-menu">
                <a href="index.php" class="menu-item"><i data-lucide="home"></i> Home</a>
                <a href="busca-projetos.php" class="menu-item active"><i data-lucide="compass"></i> Explorar</a>
                <a href="meus-projetos.php" class="menu-item"><i data-lucide="folder-open"></i> Meus Projetos</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <h1>Explorar Projetos</h1>
            </header>

            <section class="search-hero">
                <h2>Encontre novas inspirações</h2>
                <input type="text" class="search-input" placeholder="Pesquisar projetos, temas, colaboradores...">
            </section>

            <div class="projects-grid">
                <div class="project-card" onclick="openDetails('Projeto Alpha', 'Uma exploração profunda em design generativo.')">
                    <div class="card-banner"><img src="https://images.unsplash.com/photo-1550684848-fac1c5b4e853?w=400" alt="Banner"></div>
                    <span class="badge badge-green">Ativo</span>
                    <h3>Projeto Alpha</h3>
                    <p>Uma exploração profunda em design generativo.</p>
                    <div class="collaborators">
                        <div class="collab-thumb"></div>
                        <div class="collab-thumb"></div>
                    </div>
                </div>
            </div>
        </main>
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
    </script>
</body>
</html>