<?php
session_start();
require_once('./php/conexao.php');

if (!isset($_SESSION['email'])) {
    header("Location: registrarLogin.php");
    exit;
}

$email = $_SESSION['email'];

// Função para detectar tipo MIME da imagem
function getMimeType($binaryData) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    return $finfo->buffer($binaryData);
}

// Atualiza os dados do perfil (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoNome = $_POST['nome'] ?? '';
    $novoEmail = $_POST['email'] ?? '';
    $fotoPerfil = null;
    $fotoCapa = null;

    $params = [];
    $set = [];

    if (!empty($novoNome)) {
        $set[] = "nome = ?";
        $params[] = $novoNome;
    }

    if (!empty($novoEmail) && $novoEmail !== $email) {
        $set[] = "email = ?";
        $params[] = $novoEmail;
    }

    if (!empty($_FILES['profile_photo']['tmp_name'])) {
        $fotoPerfil = file_get_contents($_FILES['profile_photo']['tmp_name']);
        $set[] = "profile_photo = ?";
        $params[] = $fotoPerfil;
    }

    if (!empty($_FILES['cover_photo']['tmp_name'])) {
        $fotoCapa = file_get_contents($_FILES['cover_photo']['tmp_name']);
        $set[] = "cover_photo = ?";
        $params[] = $fotoCapa;
    }

    if (!empty($set)) {
        $sql = "UPDATE usuarios SET " . implode(', ', $set) . " WHERE email = ?";
        $params[] = $email;
        $stmt = $conexao->prepare($sql);
        $stmt->execute($params);

        if (!empty($novoEmail) && $novoEmail !== $email) {
            $_SESSION['email'] = $novoEmail;
            $email = $novoEmail;
        }
    }
}

// Pega os dados atualizados do usuário
$stmt = $conexao->prepare("SELECT nome, email, profile_photo, cover_photo FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Usuário não encontrado.";
    exit;
}

$profilePhotoUrl = '';
$coverPhotoUrl = '';

if (!empty($usuario['profile_photo'])) {
    $profilePhotoUrl = 'data:image/jpeg;base64,' . base64_encode($usuario['profile_photo']);
} else {
    $profilePhotoUrl = './imagens/user_perfil.avif';
}

if (!empty($usuario['cover_photo'])) {
    $coverPhotoUrl = 'data:image/jpeg;base64,' . base64_encode($usuario['cover_photo']);
} else {
    $coverPhotoUrl = './imagens/defalt_fundo_perfil_petshop.jpg';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/perfil.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <img src="<?= htmlspecialchars($coverPhotoUrl) ?>" alt="Foto de Capa" class="cover-photo" onerror="this.src='./imagens/defalt_fundo_perfil_petshop.jpg'">
            <img src="<?= htmlspecialchars($profilePhotoUrl) ?>" alt="Foto de Perfil" class="profile-photo" onerror="this.src='./imagens/user_perfil.avif'">
        </div>
        <div class="profile-name"><?= htmlspecialchars($usuario['nome']) ?></div>
        <div class="profile-email"><?= htmlspecialchars($usuario['email']) ?></div>

        <div class="profile-actions">
            <button id="edit-profile-btn">Editar Perfil</button>
            <button onclick="location.href='./php/logout.php'">Logout</button>
            <button onclick="location.href='logado.php'">Voltar</button>
            <button onclick="location.href='php/cadastrarPet.php'">Cadastrar Pet</button>
            <button onclick="location.href='meusPets.php'">Meus Pets</button>
        </div>

        <div id="edit-form" style="display:none; margin-top: 20px;">
            <form method="POST" enctype="multipart/form-data">
                <label>Nome:</label>
                <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required><br>

                <label>Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required><br>

                <label>Nova Foto de Perfil:</label>
                <input type="file" name="profile_photo"><br>

                <label>Nova Foto de Capa:</label>
                <input type="file" name="cover_photo"><br>

                <button type="submit">Salvar</button>
                <button type="button" onclick="document.getElementById('edit-form').style.display='none'">Cancelar</button>
            </form>
        </div>

        <div class="profile-info">
            <h3>Sobre</h3>
            <p>Bem-vindo ao Petshop, onde o bem-estar dos seus pets é nossa prioridade!</p>
        </div>
    </div>
    <script src="./js/perfilForm.js"></script>
</body>
</html>
