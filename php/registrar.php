<?php
session_start();
include './conexao.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$cep = $_POST['cep'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$senha = $_POST['senha'];

// Function to validate CPF
function validarCPF($cpf) {
    // Remove non-numeric characters
    $cpf = preg_replace('/\D/', '', $cpf);
    
    // Check if CPF has 11 digits
    if (strlen($cpf) != 11) {
        return false;
    }

    // Validate CPF digits
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

// Server-side validation for CEP
if (!preg_match('/^\d{8}$/', $cep)) {
    die("Erro: CEP inválido. Deve conter 8 dígitos.");
}

// Validate CPF
if (!validarCPF($cpf)) {
    die("Erro: CPF inválido. Deve conter 11 dígitos e ser um CPF válido.");
}

// Check if CPF already exists
$stmt = $conexao->prepare("SELECT COUNT(*) FROM usuarios WHERE cpf = ?");
$stmt->execute([$cpf]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    die("Erro: CPF já está em uso.");
}

// Hash the password
$senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

// Handle profile photo upload
$profilePhotoPath = '';
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
    // Check if there is an existing profile photo
    if (isset($_SESSION['profile_photo']) && file_exists($_SESSION['profile_photo'])) {
        // Delete the old photo
        unlink($_SESSION['profile_photo']);
    }
    
    // Set the new profile photo path
    $profilePhotoPath = 'uploads/' . $_FILES['profile_photo']['name'];
    move_uploaded_file($_FILES['profile_photo']['tmp_name'], $profilePhotoPath);
}

$stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, cpf, telefone, cep, rua, numero, bairro, cidade, estado, senha, profile_photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$nome, $email, $cpf, $telefone, $cep, $rua, $numero, $bairro, $cidade, $estado, $senha_hashed, $profilePhotoPath]);

if ($stmt) {
    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;
    $_SESSION['profile_photo'] = $profilePhotoPath; // Store the profile photo path in the session
    error_log("Profile photo path: " . $_SESSION['profile_photo']); // Debug statement
    header('Location: ../logado.php');
    exit();
} else {
    echo "Erro: " . $conexao->errorInfo()[2];
}
?>
