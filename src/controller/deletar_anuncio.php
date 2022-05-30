<?php

session_start();

include('../model/Database.php');


$db = new Database();


if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
  $id_post_deletar = $_POST['anuncio_id_excluir'];
  $db->delete_anuncio($id_post_deletar);

  unset($_POST['anuncio_id_excluir']);
}

header("location: ../view/views/Perfil.php");
