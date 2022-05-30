<?php

session_start();


$pagina = file_get_contents('../templates/principal.html');

$lista_logado = file_get_contents('../templates/lista_logado.html');
$lista_nao_logado = file_get_contents('../templates/lista_nao_logado.html');
$lista_admin = file_get_contents('../templates/lista_admin.html');
$lista_nao_admin = file_get_contents('../templates/lista_nao_admin.html');
$form_anuncio = file_get_contents('../templates/form_anuncio.html');




if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {

  $opcoes = $lista_logado;

  if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {

    $page_options = $lista_admin;
  } else {
    $page_options = $lista_nao_admin;
  }

  $pagina = str_replace("<!--SITEOPCOES-->", $page_options, $pagina);


  $pagina = str_replace("<!--OPCOESUSUARIO-->", $opcoes, $pagina);

  $pagina = str_replace("<!--CONTEUDO-->", $form_anuncio, $pagina);


  echo $pagina;
} else {

  header("location: Login.php");
}
