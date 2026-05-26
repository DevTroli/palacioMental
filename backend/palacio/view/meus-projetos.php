<?php
require_once '../controller/db_config.php';
// Busca todos os projetos
$stmt = $pdo->query("SELECT * FROM projeto WHERE id_usuario = 1");
$projetos = $stmt->fetchAll();

// Busca todas as mídias agrupadas por id_projeto
$stmt_midia = $pdo->query("SELECT * FROM midia");
$midias_all = $stmt_midia->fetchAll();
$midias_por_projeto = [];
foreach ($midias_all as $m) {
    $midias_por_projeto[$m['id_projeto']][] = $m;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palácio Mental - Meus Projetos</title>
    <link rel="stylesheet" href="../css/home-style.css">
    <link rel="stylesheet" href="../css/meus-projetos.css">
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
                <a href="index.php" class="menu-item"><i data-lucide="home"></i> Home</a>
                <a href="meus-projetos.php" class="menu-item active"><i data-lucide="folder-open"></i> Projetos</a>
            </nav>

            <div class="sidebar-footer">
                <a href="#" class="menu-item logout-btn" onclick="logout()">
                    <i data-lucide="log-out"></i>
                    Sair da Conta
                </a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <h1>Meus Projetos</h1>
                <a href="criar-projeto.php" class="btn-new-project"><i data-lucide="plus"></i> Novo Projeto</a>
            </header>

            <section class="profile-section" style="background: white; padding: 25px; border-radius: 16px; margin: 20px 40px; display: flex; align-items: center; gap: 20px; border: 1px solid var(--border-color);">
                <img src="../img/user1.jpeg" alt="Perfil" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                <div>
                    <h2 id="userNameDisplay">Aluno Yong</h2>
                    <button class="btn-edit">Editar Perfil</button>
                </div>
            </section>

            <div class="projects-grid">
                <?php foreach ($projetos as $p): ?>
                <div class="project-card">
                    <div style="margin-bottom: 15px;">
                        <span class="badge badge-purple"><?php echo htmlspecialchars($p['st_projeto']); ?></span>
                    </div>
                    <h3><?php echo htmlspecialchars($p['nm_projeto']); ?></h3>
                    <p><?php echo htmlspecialchars($p['ds_projeto']); ?></p>
                    
                    <div class="files-preview">
                        <?php if (isset($midias_por_projeto[$p['id_projeto']])): ?>
                            <?php foreach ($midias_por_projeto[$p['id_projeto']] as $midia): ?>
                                <a href="../uploads/<?php echo htmlspecialchars($midia['nm_url']); ?>" target="_blank" style="font-size: 0.8rem; display: block; color: var(--primary-purple);">
                                    <i data-lucide="file"></i> <?php echo htmlspecialchars($midia['nm_url']); ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <a href="editor-projeto.php?id=<?php echo $p['id_projeto']; ?>" class="btn-edit" style="margin-top:10px; display:inline-block;">Editar</a>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
        function logout() { window.location.href = 'login.php'; }
    </script>
</body>
</html>