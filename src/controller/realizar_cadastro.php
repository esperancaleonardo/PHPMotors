<?php

session_start();


include('../model/Database.php');

#verificar os dados no banco e controlar a sessao usuario e administrador

$db = new Database();

if (
  isset($_POST['nome']) && ($_POST['nome'] != "") &&
  isset($_POST['email']) && ($_POST['email'] != "") &&
  isset($_POST['cpf']) && ($_POST['cpf'] != "") &&
  isset($_POST['senha']) && ($_POST['senha'] != "") &&
  isset($_POST['dt_nasc']) && ($_POST['dt_nasc'] != "")
) {

  $usuario_cadastro = new Usuario("", $_POST['nome'], $_POST['email'], $_POST['cpf'], $_POST['senha'], $_POST['dt_nasc'], 'Convencional');
  $db->create_usuario($usuario_cadastro);

  header("location: ../view/views/Login.php");
  exit();
} else {
  header("location: ../view/views/Cadastro.php");
  exit();
}
