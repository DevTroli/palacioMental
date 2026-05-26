<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_projeto = $_POST['id_projeto'];
    $nome = $_POST['nm_projeto'];
    $desc = $_POST['ds_projeto'];

    try {
        $stmt = $pdo->prepare("UPDATE projeto SET nm_projeto = ?, ds_projeto = ? WHERE id_projeto = ?");
        $stmt->execute([$nome, $desc, $id_projeto]);

        header("Location: ../view/meus-projetos.php");
        exit();
    } catch (PDOException $e) {
        die("Erro ao atualizar projeto: " . $e->getMessage());
    }
}
?>