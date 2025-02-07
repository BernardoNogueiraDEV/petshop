<?php
session_start();
include './php/conexao.php';

// Recupera o e-mail do usuário logado
if (!isset($_SESSION['email'])) {
    header("Location: registrarLogin.php");
    exit;
}

$email = $_SESSION['email'];
$stmt = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$id_usuario = $stmt->fetchColumn();

if (!$id_usuario) {
    echo "Usuário não encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pets</title>
    <link rel="stylesheet" href="./css/meusPets.css">
</head>
<body>
<div class="container">
        <h1>Meus Pets</h1>
        <div class="pets">
            <?php
            $sql = "SELECT * FROM pets WHERE id_usuario = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$id_usuario]);
            $pets = $stmt->fetchAll();

            if (empty($pets)) {
                echo "Nenhum pet encontrado.";
            } else {
                foreach ($pets as $pet) {
                    echo '<div class="pet">';
                    echo '<div class="pet-info">';
                    echo '<h2>' . htmlspecialchars($pet['nomePet']) . '</h2>';
                    echo '<p><strong>Tipo:</strong> ' . htmlspecialchars($pet['tipoPet']) . '</p>';
                    echo '<p><strong>Idade:</strong> ' . htmlspecialchars($pet['idadePet']) . '</p>';
                    echo '<p><strong>Raça:</strong> ' . htmlspecialchars($pet['racaPet']) . '</p>';
                    echo '<p><strong>Nascimento:</strong> ' . htmlspecialchars($pet['nascimentoPet']) . '</p>';
                    echo '<p><strong>Observações:</strong> ' . htmlspecialchars($pet['observacoesPet']) . '</p>';
                    echo '</div>';
                    echo '<form method="POST" action="./php/cadastrarPet.php">';
                    echo '<input type="hidden" name="pet_id" value="' . htmlspecialchars($pet['id_pet']) . '">';
                    echo '<button type="submit" class="botaoExcluir" name="delete_pet">Excluir Pet</button>';
                    echo '</form>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <button onclick="location.href='./perfil.php';" class="voltar">Voltar</button>
    </div>
</body>
</html>
