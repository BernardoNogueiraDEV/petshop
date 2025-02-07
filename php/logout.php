<?php
/* logout*/
session_start();
// Unset specific session variables if needed
unset($_SESSION['nome']);
unset($_SESSION['email']);
// Optionally, keep profile photo and cover photo in session
// unset($_SESSION['profile_photo']);
// unset($_SESSION['cover_photo']);
header('Location: ../registrarLogin.php');
exit();
?>
