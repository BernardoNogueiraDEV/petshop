<?php
session_start();
require_once __DIR__ . '/php/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'], $_SESSION['email'])) {
    header("Location: registrarLogin.php");
    exit;
}
$id_usuario = (int) $_SESSION['id_usuario'];
$email      = $_SESSION['email'];

// Ativa exceções do PDO
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// Função para detectar o tipo MIME da imagem
function getImageMimeType(string $data): string
{
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->buffer($data);
    if ($mime === 'application/octet-stream' || $mime === false) {
        // fallback rudimentar: detecta PNG pelo header ou assume JPEG
        return (substr($data, 1, 3) === 'PNG') ? 'image/png' : 'image/jpeg';
    }
    return $mime;
}

// === BUSCA FOTO DE PERFIL ===
$stmtFoto = $conexao->prepare("SELECT profile_photo FROM usuarios WHERE email = ?");
$stmtFoto->execute([$email]);
$rowFoto = $stmtFoto->fetch(PDO::FETCH_ASSOC);

if ($rowFoto === false) {
    // Usuário não encontrado na tabela
    die("Erro: usuário “" . htmlspecialchars($email) . "” não existe.");
}

// Monta a URL da imagem
if (!empty($rowFoto['profile_photo'])) {
    $bin       = $rowFoto['profile_photo'];
    $mimeType  = getImageMimeType($bin);
    $base64    = base64_encode($bin);
    $profile_photo_url = "data:$mimeType;base64,$base64";
} else {
    // fallback absoluto
    $profile_photo_url = './imagens/user_perfil.avif';
}

// === BUSCA ITENS DO CARRINHO ===
$stmt = $conexao->prepare("
    SELECT id, produto, preco, quantidade
      FROM carrinho
     WHERE id_usuario = :id
");
$stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcula total
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['preco'] * $item['quantidade'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="stylesheet" href="./css/logado.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/carrinho.css">
</head>

<body style="background-color: #f3eef8;">
    <header>
        <div class="logo">
            <img src="./imagens/faviconn.jpeg" alt="Logo Petshop">
            <a href="./logado.php#pag1">
                <h5>PetShop</h5>
            </a>
        </div>
        <div class="menu">
            <ul><a href="./logado.php#pag1">SERVIÇOS</a></ul>
            <ul><a href="./logado.php#pag2">SOBRE NÓS</a></ul>
            <ul><a href="./logado.php#pag8">PRODUTOS</a></ul>
        </div>
        <div class="login" style="display: flex; flex-direction: row;">
            <div class="carrinho">
                <a href="./carrinho.php" class="carrinho">
                    <img src="./imagens/carrinho.png" alt="Carrinho de Compras">
                </a>
            </div>
            <div class="imgConta">
                <a href="./perfil.php">
                    <img
                        src="<?= htmlspecialchars($profile_photo_url) ?>"
                        alt="Foto de Perfil"
                        class="fotoPerfil"
                        onerror="this.onerror=null; this.src='./imagens/user_perfil.avif';">
                </a>
            </div>
        </div>
    </header>

    <div class="containerCarrinho">
        <div class="janelaCarrinho">
            <div id="customMessage" style="display:none;"></div>
            <div class="carrinhoTitulo">
                <h2>Carrinho de Compras</h2>
            </div>
            <div class="carrinhoConteudo">
                <?php if (!empty($cart_items)): ?>
                    <?php foreach ($cart_items as $item): ?>
                        <div class="itemCarrinho">
                            <div class="itemCarrinhoDescricao">
                                <p id="nomeProduto"><?= htmlspecialchars($item['produto']) ?></p>
                                <p id="precoProduto">Preço: R$ <?= number_format($item['preco'], 2, ',', '.') ?></p>
                                <p id="quantidadeProduto">Quantidade: <?= htmlspecialchars($item['quantidade']) ?></p>
                            </div>
                            <div class="itemCarrinhoRemover">
                                <form method="POST" action="./php/remover_item.php" style="display:inline;">
                                    <input type="hidden" name="id_item" value="<?= $item['id'] ?>">
                                    <button type="submit">Remover</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align:center; margin-top: 40px;">Seu carrinho está vazio.</p>
                <?php endif; ?>
            </div>
            <?php if (!empty($cart_items)): ?>
                <div class="carrinhoFinalizar">
                    <p id="carrinhoTotal">Total: R$ <?= number_format($total_price, 2, ',', '.') ?></p>
                    <button id="finalizarCompra">Finalizar Compra</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>