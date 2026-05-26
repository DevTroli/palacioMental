<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palácio Mental - Editar Projeto</title>
    <link rel="stylesheet" href="../css/home-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .editor-container { padding: 40px; max-width: 900px; }
        .edit-section { background: #fff; padding: 30px; border-radius: 16px; border: 1px solid var(--border-color); margin-bottom: 30px; }
        .file-list { display: flex; flex-direction: column; gap: 10px; margin-top: 15px; }
        .file-item { display: flex; justify-content: space-between; padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; }
        .version-tag { font-size: 0.8rem; background: var(--purple-light); color: var(--primary-purple); padding: 4px 8px; border-radius: 4px; }
    </style>
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
                <a href="meus-projetos.php" class="menu-item active"><i data-lucide="folder-open"></i> Meus Projetos</a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="topbar">
                <h1>Editar Projeto: Vaudevilla</h1>
                <button class="btn-new-project" onclick="alert('Alterações Salvas!')">Salvar Alterações</button>
            </header>

            <div class="editor-container">
                <section class="edit-section">
                    <h3>Detalhes Básicos</h3>
                    <div class="form-group">
                        <label>Nome do Projeto</label>
                        <input type="text" class="input-text" value="Vaudevilla">
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea rows="4" class="input-text">Projeto de Comic ficção científica</textarea>
                    </div>
                </section>

                <section class="edit-section">
                    <h3>Arquivos e Versões</h3>
                    <div class="upload-container" onclick="document.getElementById('fileUpload').click()" style="border: 2px dashed var(--border-color); padding: 20px; text-align: center; cursor: pointer; border-radius: 12px;">
                        <i class="fa-solid fa-plus"></i> Adicionar novo arquivo
                        <input type="file" id="fileUpload" style="display: none;">
                    </div>
                    <div class="file-list">
                        <div class="file-item">
                            <span>vaudevilla_v1.pdf</span>
                            <span class="version-tag">Versão 1.0</span>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>