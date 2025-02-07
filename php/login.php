<?php
session_start();
include './conexao.php';

// Verifica se os dados do formulário foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $cpf = $_POST['cpf'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Verifica se os campos estão vazios
    if (empty($cpf) || empty($senha)) {
        header("Location: ../login.php?error=empty_fields");
        exit();
    }

    // Prepara e executa a consulta ao banco de dados
    try {
        $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE cpf = :cpf");
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->execute();

        // Recupera o usuário encontrado
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário foi encontrado e se a senha está correta
        if ($user && password_verify($senha, $user['senha'])) {
            // Login bem-sucedido, armazena dados na sessão
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['cpf'] = $user['cpf']; // Pode ser útil armazenar o CPF também
            $_SESSION['profile_photo'] = $user['profile_photo']; // Store profile photo path
            $_SESSION['cover_photo'] = $user['cover_photo']; // Store cover photo path
            header("Location: ../logado.php");

            exit();
        } else {
            // Login falhou
            header("Location: ../login.php?error=invalid_credentials");
            exit();
        }
    } catch (PDOException $e) {
        // Caso haja um erro na consulta
        header("Location: ../login.php?error=db_error");
        exit();
    }
} else {
    // Redireciona para a página de login se a requisição não for POST
    header("Location: ../login.php");
    exit();
}
