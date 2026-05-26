<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['projectName'];
    $desc = $_POST['projectDesc'];
    $status = ($_POST['status'] == 'Ideia') ? 'rascunho' : 'publico'; // Mapeamento básico para ENUM
    
    // Usuário fixo (id 1) e Categoria fixa (id 1) - Garanta que existam no banco!
    $id_usuario = 1; 
    $id_categoria = 1; 

    try {
        // Inserir Projeto (tabela 'projeto' em minúsculo agora)
        $stmt = $pdo->prepare("INSERT INTO projeto (id_usuario, id_categoria, nm_projeto, ds_projeto, st_projeto) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_usuario, $id_categoria, $nome, $desc, $status]);
        $id_projeto = $pdo->lastInsertId();

        // Processar Arquivos
        if (isset($_FILES['projectFile'])) {
            $target_dir = "../uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            
            foreach ($_FILES['projectFile']['name'] as $key => $name) {
                if ($_FILES['projectFile']['error'][$key] === UPLOAD_ERR_OK) {
                    $file_name = time() . '_' . basename($name);
                    $target_file = $target_dir . $file_name;

                    if (move_uploaded_file($_FILES['projectFile']['tmp_name'][$key], $target_file)) {
                        $stmt_midia = $pdo->prepare("INSERT INTO midia (id_projeto, tp_midia, nm_url) VALUES (?, ?, ?)");
                        if (!$stmt_midia->execute([$id_projeto, 'imagem', $file_name])) {
                            error_log("Falha ao inserir mídia: " . $file_name);
                        }
                    } else {
                        error_log("Falha ao mover arquivo: " . $name);
                    }
                } else {
                    error_log("Erro de upload PHP: " . $_FILES['projectFile']['error'][$key]);
                }
            }
        }

        header("Location: /palacio/view/meus-projetos.php");
        exit();
    } catch (PDOException $e) {
        die("Erro ao criar projeto: " . $e->getMessage());
    }
}
?>
