<?php
require_once 'db_config.php';

// Aceita ID via GET (chamada do modal JS) ou POST (formulário)
$id_projeto = $_GET['id'] ?? $_POST['id_projeto'] ?? null;

if ($id_projeto) {
    try {
        // Deleta mídias associadas e o projeto
        $pdo->prepare("DELETE FROM midia WHERE id_projeto = ?")->execute([$id_projeto]);
        $pdo->prepare("DELETE FROM projeto WHERE id_projeto = ?")->execute([$id_projeto]);
        
        header("Location: ../view/meus-projetos.php");
        exit();
    } catch (PDOException $e) {
        die("Erro ao deletar projeto: " . $e->getMessage());
    }
}
?>