<?php

session_start();

$pagina = file_get_contents('../templates/principal.html');
$lista_logado = file_get_contents('../templates/lista_logado.html');
$lista_nao_logado = file_get_contents('../templates/lista_nao_logado.html');
$lista_admin = file_get_contents('../templates/lista_admin.html');
$lista_nao_admin = file_get_contents('../templates/lista_nao_admin.html');



include('../../model/Database.php');

$db = new Database();


### Verifica se está logado para dar os menus de acesso do usuario
if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
  $opcoes = $lista_logado;
} else {
  $opcoes = $lista_nao_logado;
}

if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {

  $page_options = $lista_admin;
} else {
  $page_options = $lista_nao_admin;
}

$pagina = str_replace("<!--SITEOPCOES-->", $page_options, $pagina);


$pagina = str_replace("<!--OPCOESUSUARIO-->", $opcoes, $pagina);


$anuncios = $db->get_all_anuncios();


$conteudo_anuncios = '<h1>Anúncios Ativos na Plataforma</h1>
<div class="container"><div class="conteudo" style="margin: 30px">';


foreach ($anuncios as $anuncio) {
  $conteudo_anuncios = $conteudo_anuncios . '<div class="cards"> <div class="card-item">';
  $conteudo_anuncios = $conteudo_anuncios . '<img src="' . $anuncio['anun_imagem'] . '" alt="" width=300/>';

  if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {

    $conteudo_anuncios = $conteudo_anuncios .
      "<form action='../../controller/deletar_anuncio.php' method='post' id='form_excluir_anuncio' name='form_excluir_anuncio'>
          <input type='text' id='anuncio_id_excluir' name='anuncio_id_excluir' hidden value=" . $anuncio['anun_id'] . " ></input>
          <button class='btn-edt' type='submit' id='submit_btn'>EXCLUIR</button>
        </form>";
  }
  $conteudo_anuncios = $conteudo_anuncios . '<div class="card-info"> <h3>' . $anuncio['anun_titulo'] . '</h3>';
  $conteudo_anuncios = $conteudo_anuncios . '<h2 class="card-tittle">R$ ' . number_format($anuncio['anun_valor'], 2, ",", ".") . '</h2>';
  $conteudo_anuncios = $conteudo_anuncios . '<h4 class="card-subtitle">' . $anuncio['usuario_nome'] . '</h4>';
  $conteudo_anuncios = $conteudo_anuncios . '<p class="card-intro">' . $anuncio['anun_descricao'] . '</p></div>';
  $conteudo_anuncios = $conteudo_anuncios . '</div></div>';
}

$conteudo_anuncios = $conteudo_anuncios . '</div></div>';

$pagina = str_replace("<!--CONTEUDO-->", $conteudo_anuncios, $pagina);


echo $pagina;
