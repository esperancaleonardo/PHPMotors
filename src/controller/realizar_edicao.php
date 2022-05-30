<?php

session_start();


include('../model/Database.php');

if (isset($_POST['usuario_id_edicao'])) {

  $db = new Database();

  if (
    isset($_POST['nome']) && ($_POST['nome'] != "") &&
    isset($_POST['email']) && ($_POST['email'] != "") &&
    isset($_POST['cpf']) && ($_POST['cpf'] != "") &&
    isset($_POST['senha']) && ($_POST['senha'] != "") &&
    isset($_POST['dt_nasc']) && ($_POST['dt_nasc'] != "")
  ) {
    $user_update = new Usuario($_POST['usuario_id_edicao'], $_POST['nome'], $_POST['email'], $_POST['cpf'], $_POST['senha'], $_POST['dt_nasc'], 'Convencional');
    $db->update_usuario($user_update);
    $_SESSION['usuario'] = serialize($user_update);
  }


  unset($_POST['usuario_id_edicao']);
}


if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
  header("location: ../view/views/ListaUsuario.php");
} else {
  header("location: ../view/views/Perfil.php");
}
