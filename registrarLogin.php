<?php
session_start();
if (isset($_POST['nome']) && isset($_POST['email'])) {
    $_SESSION['nome'] = $_POST['nome'];
    $_SESSION['email'] = $_POST['email'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Cadastro</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <div class="containerFoto">
        <img src="./imagens/fundoLogin.jpg" alt="fundo petshop">
    </div>
    <div class="registrar-form-container registrar-container">
        <form action="./php/registrar.php" method="post" id="registerForm">
            <div class="registrar">
                <div class="registrarR">
                    <h1 class="cadastreH1">Cadastre-se</h1>
                </div>
                <div class="registrarR">
                    <img src="./imagens/faviconn.jpeg" alt=""> <h1 style="font-family: 'TC';color: #d9bbf8;">Petshop</h1>
                </div>
                <div class="registrarR">
                    <p>Já tem uma conta? <a href="#" class="facaLogin" id="showLogin">Faça login</a></p>
                </div>
            </div>
            <div class="parteDeBaixoRegistrar">
                <div class="inputsRegistrar"> 
                    <div class="group">
                        <input required="" type="text" name="nome" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Name</label>
                    </div>
                    <div class="group">
                        <input required="" type="email" name="email" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Email</label>
                    </div>
                    <div class="group">
                        <input required="" type="text" name="cpf" class="input" >
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>CPF</label>
                    </div>
                    <div class="group">
                        <input required="" type="text" name="telefone" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Telefone</label>
                    </div>
                    <div class="group">
                        <input required="" type="text" name="cep" id="cep" class="input"> <!-- Added ID -->
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>CEP</label>
                    </div>
                    <div class="group">
                        <input required="" type="text" name="rua" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Rua</label>
                    </div>
                    <div class="group">
                        <input required="" type="text" name="numero" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Número</label>
                    </div>
                    <div class="group">
                        <input required="" type="text" name="bairro" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Bairro</label>
                    </div>
                    <div class="group">
                        <input required="" type="text" name="cidade" id="cidade" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Cidade</label>
                    </div>
                    <div class="group">
                        <input required="" type="text" name="estado" id="estado" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Estado</label>
                    </div>
                    <div class="group">
                        <input required="" type="password" name="senha" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Password</label>
                    </div>
                    <button type="submit" class="enviarRegistro" onclick="validarCPF(cpf)">
                        <div class="svg-wrapper-1">
                        <div class="svg-wrapper">
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            width="24"
                            height="24"
                            >
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path
                                fill="currentColor"
                                d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"
                            ></path>
                            </svg>
                        </div>
                        </div>
                        <span>Cadastrar-se</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="login-form-container login-container">
        <form action="./php/login.php" method="post">
            <div class="registrar">
                <div class="registrarR">
                    <h1 class="cadastreH1">Login</h1>
                </div>
                <div class="registrarR">
                    <img src="./imagens/faviconn.jpeg" alt=""> <h1 style="font-family: 'TC';color: #d9bbf8;">Petshop</h1>
                </div>
                <div class="registrarR">
                    <p>Não tem uma conta? <a href="#" class="facaLogin" id="showRegister">Cadastrar-se</a></p>
                </div>
            </div>
            <div class="parteDeBaixoLogin">
                <div class="inputsRegistrar"> 
                    <div class="group">
                        <input required="" type="text" name="cpf" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>CPF</label>
                    </div>
                    <div class="group">
                        <input required="" type="password" name="senha" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Password</label>
                    </div>
                    <button type="submit" class="enviarRegistro" onclick="validarCPF(cpf)">
                        <div class="svg-wrapper-1">
                        <div class="svg-wrapper">
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            width="24"
                            height="24"
                            >
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path
                                fill="currentColor"
                                d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"
                            ></path>
                            </svg>
                        </div>
                        </div>
                        <span>Login</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script src="./js/login.js"></script>
</body>
</html>
