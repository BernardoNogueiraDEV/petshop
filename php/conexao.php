<?php
$host = 'localhost';  // Ou o IP do seu servidor de banco de dados
$dbname = 'petshop';  // Nome do banco de dados
$username = 'root';   // Nome de usuário do banco de dados
$password = '';       // Senha do banco de dados

try {
    // Cria a conexão com o banco de dados
    $conexao = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Define o modo de erro do PDO para exceções
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Caso haja erro na conexão
    die("Erro de conexão: " . $e->getMessage());
}
?>
