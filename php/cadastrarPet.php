<?php
session_start();
include './conexao.php'; // Include database connection

// Check if the connection was successful
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle pet deletion
if (isset($_POST['delete_pet'])) {
    $pet_id = $_POST['pet_id'];
    $stmt = $conexao->prepare("DELETE FROM pets WHERE id_pet = ?");
    $stmt->execute([$pet_id]);
    header("Location: ../meusPets.php"); // Redirect back to meusPets.php
    exit;
}

// Other logic for adding pets can go here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input data
    $nome = $_POST['nomePet'];
    $tipo = $_POST['tipoPet'];
    $idade = $_POST['idadePet'];
    $raca = $_POST['racaPet'];
    $nascimento = $_POST['nascimentoPet'];
    $observacoes = $_POST['observacoes'];
    $cpf = $_POST['cpf'];

    // Retrieve id_usuario based on email from session
    $email = $_SESSION['email']; // Assuming email is stored in the session
    $stmt = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bindValue(1, $email);
    $stmt->execute();
    $id_usuario = $stmt->fetchColumn(); // Get the id_usuario

    // Validate input data
    if (empty($nome) || empty($tipo) || empty($idade) || empty($raca) || empty($nascimento) || empty($observacoes)) {
        echo "Todos os campos são obrigatórios.";
    } else {
        
        $dateTime = DateTime::createFromFormat('d/m/Y', $nascimento);
        if ($dateTime) {
            $nascimento = $dateTime->format('Y-m-d'); 
        } else {
            echo "Data de nascimento inválida.";
            exit;
        }

        // Prepare SQL statement to insert pet data
        $stmt = $conexao->prepare("INSERT INTO pets (nomePet, tipoPet, idadePet, racaPet, nascimentoPet, observacoesPet, cpf, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindValue(8, $id_usuario); // Bind id_usuario

        $stmt->bindValue(1, $nome);
        $stmt->bindValue(2, $tipo);
        $stmt->bindValue(3, $idade);
        $stmt->bindValue(4, $raca);
        $stmt->bindValue(5, $nascimento);
        $stmt->bindValue(6, $observacoes);
        $stmt->bindValue(7, $cpf);
        $stmt->bindValue(8, $id_usuario); // Bind id_usuario

        // Execute the statement
        if ($stmt->execute()) {
            header('location: ../perfil.php');
        } else {
            echo "Erro ao cadastrar pet.";
        }

        $stmt = null; // Close the statement
        $conexao = null; // Close the connection
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pet</title>
    <link rel="stylesheet" href="../css/cadastrarPet.css">
</head>

<body>
    <div class="container">
        <h1>Cadastrar Pet</h1>
        <form method="POST" action="cadastrarPet.php">
            <div class="group">
                <input required="" type="text" name="nomePet" class="input">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Nome do pet</label>
            </div>
            <div class="group">
                <input required="" type="text" name="tipoPet" class="input">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Tipo do pet</label>
            </div>
            <div class="group">
                <input required="" type="text" name="idadePet" class="input">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Idade do pet</label>
            </div>
            <div class="group">
                <input required="" type="text" name="racaPet" class="input">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Raça do pet</label>
            </div>
            <div class="group">
                <input type="text" name="nascimentoPet" class="input">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Data de nascimento</label>
            </div>
            <div class="group">
                <input required="" type="text" name="observacoes" class="input">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Observações adicionais do pet</label>
            </div>
            <div class="group">
                <input type="number" name="cpf" class="input">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>CPF de outro dono se tiver</label>
            </div>

            <button type="submit" class="enviarRegistro" onclick="validarCPF(document.querySelector('input[name=cpf]').value)">
                <div class="svg-wrapper-1">
                    <div class="svg-wrapper">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            width="24"
                            height="24">
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path
                                fill="currentColor"
                                d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"></path>
                        </svg>
                    </div>
                </div>
                <span>Cadastrar</span>
            </button>
        </form>
    </div>
    <script src="../js/cadastrarPet.js"></script>
</body>

</html>
