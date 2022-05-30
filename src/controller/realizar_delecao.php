<?php

session_start();


include('../model/Database.php');

if (isset($_POST['usuario_id_excluir'])) {

  $db = new Database();
  $usuario_cadastro = $_POST['usuario_id_excluir'];
  $db->delete_usuario($usuario_cadastro);

  unset($_POST['usuario_id_excluir']);
}

header("location: ../view/views/ListaUsuario.php");
