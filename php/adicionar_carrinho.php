<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401);
    echo "Usuário não logado.";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Verifica se os dados foram enviados
if (isset($_POST['produto']) && isset($_POST['preco'])) {
    $produto = $_POST['produto'];
    $preco = $_POST['preco'];

    try {
        // Verifica se o produto já existe no carrinho
        $verifica = $conexao->prepare("SELECT id, quantidade FROM carrinho WHERE produto = :produto AND id_usuario = :id_usuario");
        $verifica->bindValue(':produto', $produto);
        $verifica->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $verifica->execute();
        $resultado = $verifica->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $nova_quantidade = $resultado['quantidade'] + 1;
            $atualiza = $conexao->prepare("UPDATE carrinho SET quantidade = :quantidade WHERE id = :id");
            $atualiza->bindValue(':quantidade', $nova_quantidade, PDO::PARAM_INT);
            $atualiza->bindValue(':id', $resultado['id'], PDO::PARAM_INT);
            $atualiza->execute();

            if ($atualiza->rowCount() > 0) {
                echo "Atualização realizada com sucesso.";
            } else {
                echo "Falha na atualização.";
            }
        } else {
            $insere = $conexao->prepare("INSERT INTO carrinho (produto, preco, quantidade, id_usuario) VALUES (:produto, :preco, 1, :id_usuario)");
            $insere->bindValue(':produto', $produto);
            $insere->bindValue(':preco', $preco);
            $insere->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $insere->execute();

            if (!$insere->rowCount() > 0) {
                echo "Falha na inserção.";
            }
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Erro ao adicionar produto: " . $e->getMessage();
    }
} else {
    http_response_code(400);
    echo "Dados incompletos.";
}
?>
