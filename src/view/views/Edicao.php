<?php

session_start();


$pagina = file_get_contents('../templates/principal.html');
$lista_logado = file_get_contents('../templates/lista_logado.html');
$lista_nao_logado = file_get_contents('../templates/lista_nao_logado.html');
$lista_admin = file_get_contents('../templates/lista_admin.html');
$lista_nao_admin = file_get_contents('../templates/lista_nao_admin.html');

include('../../model/Database.php');

$db = new Database();


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

$dados = $db->get_usuario_by_id($_POST['usuario_id_editar']);

$form_edicao = '<form action="../../controller/realizar_edicao.php" method="post">';
$form_edicao = $form_edicao . '<input type="text" name="usuario_id_edicao" id="usuario_id_edicao" placeholder="" hidden value="' . $dados['usuario_id'] . '"/>';
$form_edicao = $form_edicao . '<input type="text" name="nome" id="nome" placeholder="" value="' . $dados['usuario_nome'] . '"/>';
$form_edicao = $form_edicao . '<input type="text" name="email" id="email" placeholder="" value="' . $dados['usuario_email'] . '"/>';
$form_edicao = $form_edicao . '<input type="text" name="cpf" id="cpf" placeholder="" value="' . $dados['usuario_cpf'] . '"/>';
$form_edicao = $form_edicao . '<input type="password" name="senha" id="senha" placeholder="" value = "' . $dados['usuario_senha'] . '" />';
$form_edicao = $form_edicao . '<input type="date" name="dt_nasc" id="dt_nasc" placeholder="" value = "' . explode(" ", $dados['usuario_dt_nasc'])[0] . '" />';
$form_edicao = $form_edicao . '<input type="submit" value="Atualizar Dados" />';
$form_edicao = $form_edicao . '</form>';

$pagina = str_replace("<!--CONTEUDO-->", $form_edicao, $pagina);


echo $pagina;
