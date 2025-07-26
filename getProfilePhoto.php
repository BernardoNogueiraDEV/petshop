<?php
session_start();
require_once('./php/conexao.php');

if (!isset($_SESSION['email'])) {
    header("Location: registrarLogin.php");
    exit;
}

$sqlFotoPefil = $conexao->prepare("SELECT profile_photo FROM usuarios WHERE email = ?");
$sqlFotoPefil->bindParam(1, $_SESSION['email']);
$sqlFotoPefil->execute();
$profile_photo = $sqlFotoPefil->fetch(PDO::FETCH_ASSOC);

if ($profile_photo) {
    header("Content-Type: image/jpeg"); // Adjust based on the actual image type
    echo $profile_photo['profile_photo'];
} else {
    // Handle case where no photo is found
    header("HTTP/1.0 404 Not Found");
}
