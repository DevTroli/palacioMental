<?php
require_once '../controller/db_config.php';
$id_projeto = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM projeto WHERE id_projeto = ?");
$stmt->execute([$id_projeto]);
$projeto = $stmt->fetch();

$stmt_midia = $pdo->prepare("SELECT * FROM midia WHERE id_projeto = ?");
$stmt_midia->execute([$id_projeto]);
$midias = $stmt_midia->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Projeto | Palácio Mental</title>
    <link rel="stylesheet" href="../css/home-style.css">
    <link rel="stylesheet" href="../css/meus-projetos.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .editor-section { background: #fff; padding: 30px; border-radius: 16px; margin-bottom: 25px; border: 1px solid var(--border-color); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .editor-title { font-size: 1.5rem; margin-bottom: 20px; color: var(--text-dark); }
        .file-item { display: flex; justify-content: space-between; align-items: center; padding: 12px; border-bottom: 1px solid #f1f5f9; }
        .btn-delete { background: #fee2e2; color: #dc2626; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; }
        .btn-delete:hover { background: #fecaca; }
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
                <a href="meus-projetos.php" class="menu-item active"><i data-lucide="folder-open"></i> Projetos</a>
            </nav>
        </aside>

        <main class="main-content" style="padding: 40px;">
            <header style="margin-bottom: 30px;">
                <a href="meus-projetos.php" style="color: var(--text-muted); text-decoration: none;"><i data-lucide="arrow-left"></i> Voltar</a>
                <h1 style="font-size: 2.5rem; margin-top: 10px;"><?php echo htmlspecialchars($projeto['nm_projeto']); ?></h1>
            </header>

            <form action="../controller/editar_projeto_processar.php" method="POST">
                <input type="hidden" name="id_projeto" value="<?php echo $id_projeto; ?>">
                <div class="editor-section">
                    <h2 class="editor-title">Editar Nome</h2>
                    <input type="text" name="nm_projeto" value="<?php echo htmlspecialchars($projeto['nm_projeto']); ?>" class="input-text" style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px;">
                </div>
                <div class="editor-section">
                    <h2 class="editor-title">Editar Descrição</h2>
                    <textarea name="ds_projeto" class="input-text" style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px;" rows="4"><?php echo htmlspecialchars($projeto['ds_projeto']); ?></textarea>
                </div>
            </form>

            <div class="editor-section">
                <h2 class="editor-title">Verificar arquivos</h2>
                <div class="file-list">
                    <?php foreach ($midias as $m): ?>
                    <div class="file-item">
                        <span><?php echo htmlspecialchars($m['nm_url']); ?></span>
                        <div style="display:flex; gap: 10px;">
                            <a href="../uploads/<?php echo htmlspecialchars($m['nm_url']); ?>" download class="btn-new-project" style="background: #3b82f6; color: white; padding: 6px 12px; font-size: 0.8rem; text-decoration:none; border-radius: 8px;">Baixar</a>
                            <a href="../controller/deletar_midia.php?id=<?php echo $m['id_midia']; ?>&projeto=<?php echo $id_projeto; ?>" class="btn-new-project" style="background: #7c3aed; color: white; padding: 6px 12px; font-size: 0.8rem; text-decoration:none; border-radius: 8px;">Deletar</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <form action="../controller/upload_midia.php" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
                    <input type="hidden" name="id_projeto" value="<?php echo $id_projeto; ?>">
                    <input type="file" name="file[]" multiple required>
                    <button type="submit" class="btn-new-project" style="margin-top: 15px;"><i data-lucide="plus"></i> Adicionar Arquivo</button>
                </form>
            </div>

            <div class="editor-section" style="text-align: center; border-color: #fee2e2;">
                <button type="button" class="btn-delete" onclick="showConfirm('delete')"><i data-lucide="trash-2"></i> Deletar Projeto</button>
            </div>

            <button type="button" class="btn-new-project" style="width: 100%; padding: 15px; font-size: 1rem;" onclick="showConfirm('save')">Salvar Alterações</button>
        </main>
    </div>

    <div id="confirmModal" style="display:none; position: fixed; top:0; left:0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
        <div style="background: white; padding: 30px; border-radius: 12px; text-align: center;">
            <h3 id="modalMsg">Confirmar ação?</h3>
            <div style="margin-top: 20px;">
                <button onclick="hideConfirm()" style="padding: 8px 16px; margin-right: 10px;">Cancelar</button>
                <button id="modalConfirmBtn" style="padding: 8px 16px; background: #7c3aed; color: white; border: none; border-radius: 4px;">Confirmar</button>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        function showConfirm(action) {
            const modal = document.getElementById('confirmModal');
            const msg = document.getElementById('modalMsg');
            const btn = document.getElementById('modalConfirmBtn');
            if(action === 'save') {
                msg.innerText = "Confirmar salvamento de alterações?";
                btn.onclick = () => document.querySelector('form').submit();
            } else {
                msg.innerText = "Tem certeza que deseja deletar este projeto?";
                btn.onclick = () => window.location.href = '../controller/deletar_projeto.php?id=<?php echo $id_projeto; ?>';
            }
            modal.style.display = 'flex';
        }
        function hideConfirm() { document.getElementById('confirmModal').style.display = 'none'; }
    </script>
</body>
</html>