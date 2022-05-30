<?php

session_start();


#verificar os dados no banco e controlar a sessao usuario e administrador

unset($_SESSION['logado']);
unset($_SESSION['admin']);
unset($_SESSION['usuario']);


header("location: ../view/views/home.php");
