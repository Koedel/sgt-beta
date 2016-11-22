<?php if(!isset($_SESSION)){session_start();}

    unset($_SESSION['cdUsuario']);
    header("Location: login.php");
?>
