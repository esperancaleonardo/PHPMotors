<?php

session_start();

include('../model/Database.php');


$db = new Database();


if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
  $temp_file = $_FILES['imagem'];
  $temp_path = $temp_file['tmp_name'];
  $uploaded = file_get_contents($temp_path);

  $anuncio_cadastrar = new Anuncio(
    "",
    $_POST['titulo'],
    $_POST['valor'],
    'data:image/jpeg;base64,' . base64_encode($uploaded),
    $_POST['descricao'],
    $_POST['data_anuncio'],
    true,
    unserialize($_SESSION['usuario'])->get_usuario_id()
  );

  $db->create_anuncio($anuncio_cadastrar);

  header("location: ../view/views/Perfil.php");
} else {
  header("location: ../view/views/Anuncio.php");
}
