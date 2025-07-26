<?php
session_start();
require_once './conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    echo "Você precisa estar logado.";
    exit;
}

if (isset($_POST['id_item'])) {
    $id = $_POST['id_item'];
    $id_usuario = $_SESSION['id_usuario'];

    $stmt = $conexao->prepare("DELETE FROM carrinho WHERE id = ? AND id_usuario = ?");
    $stmt->execute([$id, $id_usuario]);

    header("Location: ../carrinho.php");
    exit;
} else {
    echo "ID inválido.";
}
?>
