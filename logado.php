<?php
session_start(); // Certifique-se de que esta linha esteja apenas uma vez
if (isset($_POST['nome']) && isset($_POST['email'])) {
    $_SESSION['nome'] = $_POST['nome'];
    $_SESSION['email'] = $_POST['email'];
    
    // Somente atualiza a foto do perfil se um novo arquivo for enviado
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $_SESSION['profile_photo'] = $_FILES['profile_photo']['name'];
    }
}
// Recupera o e-mail do usuário logado
if (!isset($_SESSION['email'])) {
    header("Location: registrarLogin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petshop</title>
    <link rel="shortcut icon" href="./imagens/faviconn.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/logado.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="./imagens/faviconn.jpeg" alt="Logo Petshop">
            <a href="#pag1">
                <h5>PetShop</h5>
            </a>
        </div>
        <div class="menu">
            <ul><a href="#pag3">SERVIÇOS</a></ul>
            <ul><a href="#pag2">SOBRE NÓS</a></ul>
            <ul><a href="#pag8">PRODUTOS</a></ul>
        </div>
        <div class="login">
            <div class="imgConta">
                <a href="./perfil.php">
                    <?php if (isset($_SESSION['profile_photo']) && file_exists($_SESSION['profile_photo'])): ?>
                        <img src="<?php echo htmlspecialchars($_SESSION['profile_photo']); ?>" alt="avatar da conta" id="photoPreview">
                    <?php else: ?>
                        <img src="./imagens/user_perfil.avif" alt="avatar padrão" id="photoPreview"> <!-- Imagem padrão -->
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </header>
    <div class="pag1" id="pag1">
        <div class="textoConhecer">
            <h1>Venha <br> conhecer <br> o nosso</h1>
        </div>
        <div class="textoPetshop ">
            <h1>Pet <br> shop</h1>
        </div>
        <div class="estrelinha">
            <img src="./imagens/estrelinhas_petshop.png" alt="Estrelinha">
        </div>
        <div class="rabisco">
            <img src="./imagens/rabisco_petshop.png" alt="Rabisco">
        </div>
        <div class="imgCachoro">
            <img src="./imagens/cachorro_petshop.png" alt="Cachorro">
        </div>
        <div class="imgManchinhas ">
            <img src="./imagens/manchinhas_petshop.png" alt="Manchinhas">
        </div>
    </div>
    <div class="pag2" id="pag2">
        <div class="fundoBranco">
            <h1>Oi humano <br> quer saber mais <br> sobre o nosso <br> petshop?</h1>
        </div>
        <div class="imgCachorroOlhandoProAlto">
            <img src="./imagens/cachorro_olhando_pro_alto_petshop.png" alt="Cachorro olhando pro alto">
        </div>
        <div class="rabisco2 ">
            <img src="./imagens/rabisco_petshop.png" alt="Rabisco">
        </div>
        <div class="estrelinha2">
            <img src="./imagens/estrelinha2_petshop.png" alt="Estrelinha">
        </div>
        <div class="textoSobreNos" id="textoSobreNos">
            <h1 id="h1Escrever">
            </h1>
        </div>
    </div>
    <div class="pag3" id="pag3">
        <div class="bolaBranca">
        </div>
        <div class="nossosServicos">
            <h1>
                Nossos <br> serviços
            </h1>
        </div>
        <div class="rabiscoAzul">
            <img src="./imagens/cachorroBolinha_petshop.png" alt="cachorro com bolinha" class="cachorroComBolinha">
            <img src="./imagens/rabiscoAzul_petshop.png" alt="rabisco azul">
        </div>
        <div class="animar_caixas">
            <div class="caixasAzul" id="banhoTosa" onclick="banhoTosa()">
                <div class="caixasVermelhas" id="banhoTosa2"></div>
            </div>
            <div class="caixasAzul" id="consulta" onclick="consulta()">
                <div class="caixasVermelhas" id="consulta2"></div>
            </div>
            <div class="caixasAzul" id="vacinacao" onclick="vacinacao()">
                <div class="caixasVermelhas" id="vacinacao2"></div>
            </div>
            <div class="caixasAzul" id="hotelPet" onclick="hotelPet()">
                <div class="caixasVermelhas" id="hotelPet2"></div>
            </div>
        </div>

    </div>
    <div class="pag4" id="pag4">
        <div class="quadradoDividido">
            <div class="quadrado1">
                <h1>
                    Banho <br> & Tosa
                </h1>
            </div>
            <div class="quadrado2">
                <div class="promoBasico">

                </div>
                <div class="promoCompleto">

                </div>
            </div>
        </div>
        <div class="cachorroEmPe">
            <img src="./imagens/cachorroEmPe_petshop.png" alt="cachorro em pé">
        </div>
        <div class="estrelinhaBranca">
            <img src="./imagens/estrelinha_branca_petshop.png" alt="estrelinha branca">
        </div>
        <div class="textoBanhoTosa">
            <h1 id="textoBanhoTosa"></h1>
        </div>
    </div>
    <div class="pag5" id="pag5">
        <div class="rabiscoPag5">
            <img src="./imagens/rabisco_petshop.png" alt="rabisco amarelo">
        </div>
        <div class="manchinhasBrancasPag5">
            <img src="./imagens/manchinhasBrancas_petshop.png" alt="manchinhas brancas">
        </div>
        <div class="gato">
            <img src="./imagens/gatinho_petshop.png" alt="gato">
        </div>
        <div class="container">
            <h1 class="textoConsulta">Consulta</h1>
            <div class="divAmarela">
                <div class="textoAmarelo">
                    <h1>Consulta geral</h1>
                </div>
                <div class="valorAmarelo">
                    <h1>R$ 80,00</h1>
                </div>
            </div>
            <div class="divAmarela">
                <div class="textoAmarelo">
                    <h1>Odontologia</h1>
                </div>
                <div class="valorAmarelo">
                    <h1>R$ 99,00</h1>
                </div>
            </div>
            <div class="divAmarela">
                <div class="textoAmarelo">
                    <h1>Fisioterapia</h1>
                </div>
                <div class="valorAmarelo">
                    <h1>R$ 110,00</h1>
                </div>
            </div>
            <div class="divAmarela">
                <div class="textoAmarelo">
                    <h1>Demartologia</h1>
                </div>
                <div class="valorAmarelo">
                    <h1>R$ 210,00</h1>
                </div>
            </div>
            <div class="divAmarela">
                <div class="textoAmarelo">
                    <h1>Cardiologia</h1>
                </div>
                <div class="valorAmarelo">
                    <h1>R$ 220,00</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="pag6" id="pag6">
        <div class="containerPag6">
            <h1 class="vacinacaoh1">Vacinação</h1>
            <div class="linha">
                <div class="vacinas">
                    <h1>Vacina V3</h1>
                </div>
                <div class="valoresVacinas">
                    <h1>R$ 19,90</h1>
                </div>
                <div class="vacinas">
                    <h1>Vacina V8</h1>
                </div>
                <div class="valoresVacinas">
                    <h1>R$ 49,90</h1>
                </div>
            </div>
            <div class="linha">
                <div class="vacinas">
                    <h1>Vacina V4</h1>
                </div>
                <div class="valoresVacinas">
                    <h1>R$ 29,90</h1>
                </div>
                <div class="vacinas">
                    <h1>Vacina V10</h1>
                </div>
                <div class="valoresVacinas">
                    <h1>R$ 59,90</h1>
                </div>
            </div>
            <div class="linha">
                <div class="vacinas">
                    <h1>Vacina V5</h1>
                </div>
                <div class="valoresVacinas">
                    <h1>R$ 39,90</h1>
                </div>
                <div class="vacinas">
                    <h1>Vacina de raiva</h1>
                </div>
                <div class="valoresVacinas">
                    <h1>R$ 69,90</h1>
                </div>
            </div>
        </div>
        <div class="animaisNoMuro">
            <img src="./imagens/animais_no_muro_petshop.png" alt="animais no muro">
        </div>
    </div>
    <div class="pag7" id="pag7">
        <div class="containerGato">
            <div class="containerVerdeAgua">
                <div class="casaAzul">
                    <img src="./imagens/casaAzul_petshop.png" alt="casaAzul_petshop">
                </div>
                <div class="gatoOlhoAzul">
                    <img src="./imagens/gatoCinza_petshop.png" alt="gato cinza olho azul">
                </div>
            </div>
            <div class="containerAmarelo">
                <h1>Miau Miau</h1>
            </div>
            <div class="estrelinhaBrancaPag7">
                <img src="./imagens/estrelinha_branca_petshop.png" alt="estrelinha branca hotelPet">
            </div>
            <div class="estrelinhaBranca2Pag7">
                <img src="./imagens/estrelinha_branca_petshop.png" alt="estrelinha branca hotelPet2">
            </div>
        </div>
        <div class="containerHotel">
            <h1 class="hotelPetTexto">
                Hotel pet
            </h1>
            <h2>
                Viaje com tranquilidade, nós cuidados do seu pet. Oferecemos diversão, conforto e segurança. 
            </h2>
            <div class="containerDiaria">
                <div class="diaria">
                    <h1>Diária | R$89,90</h1>
                </div>
                <div class="diaria" id="diaria2">
                    <h1>7 Dias | R$600,00</h1>
                </div>
                <div class="diaria" id="diaria3">
                    <h1>10 Dias | R$900,00</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="pag8" id="pag8">
        <div class="bolaBranca"></div>
        <div class="caixas_produtos">
            <div class="caixaCima" id="" onclick="racaoEpetisco()">
                <div class="caixaBaixo" id=""><h1 class="racoesEpetiscos">Rações e Petiscos</h1></div>
            </div>
            <div class="caixaCima" id="" onclick="brinquedos()">
                <div class="caixaBaixo" id=""><h1 class="brinquedos">Brinquedos</h1></div>
            </div>
            <div class="caixaCima" id="" onclick="acessorios()">
                <div class="caixaBaixo" id=""><h1 class="acessorios">Acessórios</h1></div>
            </div>
            <div class="caixaCima" id="" onclick="higiene()">
                <div class="caixaBaixo" id=""><h1 class="produtosHigiene">Produtos de higiene</h1></div>
            </div>
            <div class="caixaCima" id="" onclick="medicamentoEsuplemento()">
                <div class="caixaBaixo" id=""><h1 class="medicamentos">Medicamentos e suplementos</h1></div>
            </div>
            <div class="caixaCima" id="" onclick="aquarismo()">
                <div class="caixaBaixo" id=""><h1 class="aquarismo">Aquarismo</h1></div>
            </div>
            <div class="caixaCima" id="" onclick="roedores()">
                <div class="caixaBaixo" id=""><h1 class="roedoresEaves">Roedores e Aves</h1></div>
            </div>
            <div class="caixaCima" id="" onclick="cuidadoEbeleza()">
                <div class="caixaBaixo" id=""><h1 class="itensBeleza">Itens de cuidado e beleza</h1></div>
            </div>
        </div>
    </div>
    <script src="./js/index.js"></script>
</body>
</html>
