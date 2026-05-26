<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palácio Mental - Novo Projeto</title>
    <link rel="stylesheet" href="../css/home-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { background-color: #ffffff; display: flex; height: 100vh; overflow: hidden; zoom: 0.8; color: #1E293B; }
        .sidebar-steps { width: 320px; background-color: #2D2D30; border-right: 1px solid var(--border-color); padding: 40px 24px; display: flex; flex-direction: column; color: #ffffff; height: 130vh; }
        .logo-area { display: flex; flex-direction: column; align-items: center; text-align: center; gap: 10px; margin-bottom: 40px; }
        .main-logo { width: 90px; height: auto; }
        .logo-area h2 { font-size: 18px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px; text-transform: uppercase; }
        .steps-container { display: flex; flex-direction: column; gap: 28px; flex-grow: 1; }
        .step-item { display: flex; align-items: center; gap: 16px; position: relative; }
        .step-number { width: 42px; height: 42px; border-radius: 50%; border: 2px solid #52525b; background-color: #3f3f46; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #a1a1aa; z-index: 2; }
        .step-item.active .step-number { border-color: var(--primary-purple); background-color: var(--primary-purple); color: #ffffff; }
        .step-info h3 { font-size: 15px; font-weight: 600; color: #a1a1aa; }
        .step-item.active .step-info h3 { color: #ffffff; }
        .main-content { flex-grow: 1; display: flex; flex-direction: column; height: 100vh; }
        .form-header { padding: 32px 64px; border-bottom: 1px solid var(--border-color); }
        .form-body { flex-grow: 1; padding: 48px 64px; max-width: 800px; width: 100%; }
        .form-step { display: none; }
        .form-step.active { display: block; animation: fadeIn 0.4s; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .form-group { margin-bottom: 28px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; }
        .input-text, select, textarea { width: 100%; padding: 14px; border: 1px solid var(--border-color); border-radius: 12px; font-size: 15px; outline: none; }
        .status-options { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .status-card { border: 2px solid var(--border-color); border-radius: 12px; padding: 16px; cursor: pointer; text-align: center; }
        .status-card.active { border-color: var(--primary-purple); background-color: #e0e7ff; }
        .btn { padding: 14px 28px; border-radius: 12px; font-weight: 600; cursor: pointer; border: none; }
        .btn-secondary { background-color: transparent; color: var(--text-muted); }
        .btn-primary { background-color: var(--primary-purple); color: #ffffff; }
    </style>
</head>
<body>

    <aside class="sidebar-steps">
        <div>
            <div class="logo-area">
                <img src="../img/logo-mindpalace.png" alt="Logo Palácio Mental" class="main-logo">
                <h2>Palácio Mental</h2>
            </div>
            <div class="steps-container">
                <div class="step-item active" id="stepIndicator1">
                    <div class="step-number">1</div>
                    <div class="step-info"><h3 id="labelStep1">Fundação</h3></div>
                </div>
                <div class="step-item" id="stepIndicator2">
                    <div class="step-number">2</div>
                    <div class="step-info"><h3 id="labelStep2">Identidade</h3></div>
                </div>
                <div class="step-item" id="stepIndicator3">
                    <div class="step-number">3</div>
                    <div class="step-info"><h3 id="labelStep3">Colaboradores</h3></div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" style="color:white;" onclick="window.history.back()"><i class="fa-solid fa-arrow-left"></i> Voltar</button>
    </aside>

    <main class="main-content">
        <header class="form-header">
            <h1 id="pageTitle">Criar Novo Projeto</h1>
        </header>

        <form id="projectForm" class="form-body" onsubmit="event.preventDefault();" enctype="multipart/form-data">
            <div id="fileError" style="display:none; color: #dc2626; padding: 10px; background: #fee2e2; border-radius: 8px; margin-bottom: 20px;"></div>

            <div class="form-step active" id="stepContent1">
                <div class="form-group">
                    <label for="projectName">Nome do Projeto *</label>
                    <input type="text" id="projectName" name="projectName" class="input-text" placeholder="Ex: Projeto Marte..." required>
                </div>
                <div class="form-group">
                    <label for="projectCategory">Categoria</label>
                    <select id="projectCategory" name="projectCategory" class="input-text">
                        <option value="design">Design & UX</option>
                        <option value="filmes">Filmes & Vídeos</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status Inicial</label>
                    <div class="status-options">
                        <div class="status-card active" onclick="selectStatus(this)"><h4>Ideia</h4></div>
                        <div class="status-card" onclick="selectStatus(this)"><h4>Em andamento</h4></div>
                        <div class="status-card" onclick="selectStatus(this)"><h4>Ativo</h4></div>
                    </div>
                    <input type="hidden" id="projectStatus" name="status" value="Ideia">
                </div>
                <div class="form-group"><button type="button" class="btn btn-primary" onclick="changeStep(1)">Próximo Passo</button></div>
            </div>

            <div class="form-step" id="stepContent2">
                <div class="form-group">
                    <label for="projectDesc">Descrição Curta</label>
                    <textarea id="projectDesc" name="projectDesc" rows="4" class="input-text"></textarea>
                </div>
                <div class="form-group">
                    <label for="fileInput">Arquivos do Projeto</label>
                    <div style="margin-top: 10px;">
                        <button type="button" class="btn btn-primary" style="background-color: var(--primary-purple);" onclick="document.getElementById('fileInput').click()">Escolher Arquivos</button>
                        <input type="file" id="fileInput" name="projectFile[]" style="display: none;" multiple onchange="handleFileSelect(this)">
                        <div id="previewArea" style="margin-top: 10px; font-size: 12px; color: var(--text-muted);"></div>
                    </div>
                </div>
                <div class="form-group"><button type="button" class="btn btn-secondary" onclick="changeStep(-1)">Anterior</button> <button type="button" class="btn btn-primary" onclick="changeStep(1)">Próximo Passo</button></div>
            </div>

            <div class="form-step" id="stepContent3">
                <div class="form-group"><label for="searchMembers">Convidar Colaboradores</label><input type="text" id="searchMembers" class="input-text" placeholder="Nome ou e-mail..."></div>
                <div class="form-group"><button type="button" class="btn btn-secondary" onclick="changeStep(-1)">Anterior</button> <button type="button" class="btn btn-primary" onclick="changeStep(1)">Próximo Passo</button></div>
            </div>

            <div class="form-step" id="stepContent4">
                <div class="form-group"><h3>Finalizar</h3><p>Confirmar criação do projeto.</p></div>
                <div class="form-group"><button type="button" class="btn btn-secondary" onclick="changeStep(-1)">Anterior</button> <button type="button" class="btn btn-primary" onclick="saveAndFinish()">Confirmar Finalização</button></div>
            </div>
        </form>
    </main>

    <script>
        let selectedFiles = new DataTransfer();

        function handleFileSelect(input) {
            validateFileSize(input);
            const previewArea = document.getElementById('previewArea');
            for (let i = 0; i < input.files.length; i++) {
                selectedFiles.items.add(input.files[i]);
            }
            input.files = selectedFiles.files;

            if (selectedFiles.files.length > 0) {
                let html = '<ul style="list-style: none; padding: 0; max-height: 150px; overflow-y: auto;">';
                for (let i = 0; i < selectedFiles.files.length; i++) {
                    html += `<li style="padding: 5px 0; border-bottom: 1px solid #eee;">
                                <i class="fa-solid fa-file"></i> ${selectedFiles.files[i].name}
                             </li>`;
                }
                html += '</ul>';
                previewArea.innerHTML = html;
            }
        }
        function validateFileSize(input) {
            const maxSize = 5 * 1024 * 1024;
            const errorDiv = document.getElementById('fileError');
            if (input.files.length > 0 && input.files[0].size > maxSize) {
                errorDiv.innerText = "Arquivo muito grande! Máximo 5MB.";
                errorDiv.style.display = 'block';
                input.value = '';
            } else { errorDiv.style.display = 'none'; }
        }
        function changeStep(dir) {
            document.getElementById(`stepContent${currentStep}`).classList.remove('active');
            document.getElementById(`stepIndicator${currentStep}`).classList.remove('active');
            currentStep += dir;
            document.getElementById(`stepContent${currentStep}`).classList.add('active');
            document.getElementById(`stepIndicator${currentStep}`).classList.add('active');
        }
        let currentStep = 1;
        function selectStatus(el) {
            document.querySelectorAll('.status-card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('projectStatus').value = el.querySelector('h4').innerText;
        }
        function saveAndFinish() {
            const form = document.getElementById('projectForm');
            const formData = new FormData(form);
            
            // Corrige o envio de múltiplos arquivos
            const fileInput = document.getElementById('fileInput');
            formData.delete('projectFile[]');
            for (let i = 0; i < selectedFiles.files.length; i++) {
                formData.append('projectFile[]', selectedFiles.files[i]);
            }
            
            const status = document.querySelector('.status-card.active h4').innerText;
            formData.append('status', status);
            
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/palacio/controller/criar_projeto_processar.php', true);
            xhr.onload = function() { window.location.href = 'meus-projetos.php'; };
            xhr.send(formData);
        }
    </script>
</body>
</html>