<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $id_projeto = $_POST['id_projeto'];
    $tp_midia = $_POST['tp_midia']; // 'imagem', 'video', etc.
    
    $target_dir = "../uploads/";
    $file_name = time() . '_' . basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $stmt = $pdo->prepare("INSERT INTO MIDIA (id_projeto, tp_midia, nm_url) VALUES (?, ?, ?)");
        $stmt->execute([$id_projeto, $tp_midia, $file_name]);
        
        echo "Arquivo enviado com sucesso!";
    } else {
        echo "Erro ao enviar o arquivo.";
    }
}
?>
