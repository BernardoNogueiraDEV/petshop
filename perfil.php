<?php
session_start();
include './php/conexao.php'; // Inclua o arquivo de conexão

// Recupera o e-mail do usuário logado
if (!isset($_SESSION['email'])) {
    header("Location: registrarLogin.php");
    exit;
}
$email = $_SESSION['email'];

// Recupera os dados atuais do usuário do banco de dados
$sql = "SELECT nome, email, profile_photo, cover_photo FROM usuarios WHERE email = ?";
$stmt = $conexao->prepare($sql);
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o usuário foi encontrado
if (!$user) {
    echo "Usuário não encontrado.";
    exit; // Encerra a execução do script se o usuário não for encontrado
}

// Dados recebidos do formulário (se não houver valores, mantêm os atuais)
$nome = $_POST['nome'] ?? $user['nome'];
$emailNovo = $_POST['email'] ?? $user['email'];

// Verifica se a pasta "uploads" existe, se não, cria
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

// Verifica se as fotos existem no banco de dados ou usa valores padrões
$profilePhoto = $_FILES['profile_photo']['name'] ?? ($user['profile_photo'] ?? './imagens/user_perfil.avif'); // Valor padrão se não houver foto
$coverPhoto = $_FILES['cover_photo']['name'] ?? ($user['cover_photo'] ?? './imagens/defalt_fundo_perfil_petshop.jpg'); // Valor padrão se não houver foto

// Verifica se o usuário alterou algum dado
$updateNome = ($nome !== $user['nome']);
$updateEmail = ($emailNovo !== $user['email']);
$updateProfilePhoto = isset($_FILES['profile_photo']) && $_FILES['profile_photo']['name'] !== '' && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK;
$updateCoverPhoto = isset($_FILES['cover_photo']) && $_FILES['cover_photo']['name'] !== '' && $_FILES['cover_photo']['error'] === UPLOAD_ERR_OK;

// Se algum dado foi alterado, atualize os dados no banco de dados
if ($updateNome || $updateEmail || $updateProfilePhoto || $updateCoverPhoto) {
    // Se as fotos foram alteradas, você precisa fazer o upload das novas fotos
    if ($updateProfilePhoto) {
        // Aqui, você pode salvar o novo arquivo da foto de perfil (validação e upload do arquivo)
        $profilePhotoPath = 'uploads/' . $_FILES['profile_photo']['name'];  // exemplo de caminho
        move_uploaded_file($_FILES['profile_photo']['tmp_name'], $profilePhotoPath);
    } else {
        // Mantém a foto antiga
        $profilePhotoPath = $user['profile_photo'];  // Caminho da foto antiga
    }

    if ($updateCoverPhoto) {
        // Aqui, você pode salvar o novo arquivo da foto de capa (validação e upload do arquivo)
        $coverPhotoPath = 'uploads/' . $_FILES['cover_photo']['name'];  // exemplo de caminho
        move_uploaded_file($_FILES['cover_photo']['tmp_name'], $coverPhotoPath);
    } else {
        // Mantém a foto de capa antiga
        $coverPhotoPath = $user['cover_photo'];  // Caminho da foto de capa antiga
    }

    // Atualiza os dados do banco de dados com os novos valores
    $sql = "UPDATE usuarios SET nome = ?, email = ?, profile_photo = ?, cover_photo = ? WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$nome, $emailNovo, $profilePhotoPath, $coverPhotoPath, $email]);

    // Store the profile photo path in the session
    $_SESSION['profile_photo'] = $profilePhotoPath; // Add this line after updating the database
    $_SESSION['cover_photo'] = $coverPhotoPath; // Add this line to store cover photo path
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil do Usuário</title>
  <link rel="stylesheet" href="./css/perfil.css">
</head>
<body>
<div class="profile-container">
    <div class="profile-header">
      <img src="<?php echo isset($_SESSION['cover_photo']) ? htmlspecialchars($_SESSION['cover_photo']) : './imagens/defalt_fundo_perfil_petshop.jpg'; ?>" alt="Foto de capa" class="cover-photo">
      <img src="<?php echo isset($_SESSION['profile_photo']) ? htmlspecialchars($_SESSION['profile_photo']) : './imagens/user_perfil.avif'; ?>" alt="Foto de perfil" class="profile-photo">
    </div>
    <div class="profile-name"><?php echo htmlspecialchars($nome); ?></div>
    <div class="profile-email"><?php echo htmlspecialchars($email); ?></div>

    <div class="profile-actions">
      <button onclick="document.getElementById('edit-form').style.display = 'block';">Editar Perfil</button>
      <button onclick="location.href='./php/logout.php';">Logout</button>
      <button onclick="location.href='./logado.php';">Voltar</button>
      <button onclick="location.href='./php/cadastrarPet.php';">Cadastrar Pet</button>
      <button onclick="location.href='./meusPets.php'">Meus Pets</button>
    </div>

    <!-- Formulário para editar os dados -->
    <div id="edit-form" style="display: none; margin-top: 20px;">
      <form method="POST" enctype="multipart/form-data">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
        <br>
        <label for="profile_photo">Foto de Perfil:</label>
        <input type="file" name="profile_photo" id="profile_photo">
        <br>
        <label for="cover_photo">Foto de Capa:</label>
        <input type="file" name="cover_photo" id="cover_photo">
        <br>
        <button type="submit">Salvar</button>
        <button class="cancelar" onclick="document.getElementById('edit-form').style.display='none';">Cancelar</button>
      </form>
    </div>

    <div class="profile-info">
      <h3>Sobre</h3>
      <p>Bem-vindo ao Petshop, onde o bem-estar e a felicidade dos seus pets são nossa prioridade! Oferecemos produtos, serviços e atendimento de qualidade para cuidar do seu melhor amigo.</p>
    </div>
  </div>
</body>
</html>
