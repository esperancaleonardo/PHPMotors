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

$usuarios = $db->get_all_users();

if (sizeof($usuarios) > 0) {
  $conteudo_usuarios = '<div style=" display:flex;justify-content:center; align-items:center;"><h1>Usuários Cadastrados</h1></div>';
  $conteudo_usuarios = $conteudo_usuarios . '<div style="display:flex;justify-content:center;align-itens:center; margin:0 auto;padding-inline: auto;">';
  $conteudo_usuarios = $conteudo_usuarios . '<table class="table-data" id="table-usuarios">';
  $conteudo_usuarios = $conteudo_usuarios . '<thead><th>email</th><th>cpf</th><th>data cadastro </th><th>ações</th></thead><tbody>';

  foreach ($usuarios as $usuario) {


    $conteudo_usuarios = $conteudo_usuarios . "<tr><td>" . $usuario->get_usuario_email() . "</td><td>" . $usuario->get_usuario_cpf() . "</td><td>" . $usuario->get_usuario_dt_nasc() . "</td>";

    $conteudo_usuarios = $conteudo_usuarios . "<td><form action='Edicao.php' method='post' id='form_editar' name='form_editar'>
                                                <input type='text' id='usuario_id_editar' name='usuario_id_editar' value=" . $usuario->get_usuario_id() . " hidden></input>
                                                <button class='btn-edt' type='submit' id='submit_btn'>EDITAR</button>
                                            </form>";

    $conteudo_usuarios = $conteudo_usuarios . "<form action='../../controller/realizar_delecao.php' method='post' id='form_excluir' name='form_excluir'>
                                                <input type='text' id='usuario_id_excluir' name='usuario_id_excluir' value=" . $usuario->get_usuario_id() . " hidden ></input>
                                                <button class='btn-edt' type='submit' id='submit_btn' >EXCLUIR</button>
                                            </form></td></tr>";
  }

  $conteudo_usuarios = $conteudo_usuarios .  '</tbody></table></div>';
} else {
  $conteudo_usuarios = '<div><h1>Usuários Cadastrados</h1><h3>Não há usuários cadastrados!</h3></div>';
}


$pagina = str_replace("<!--CONTEUDO-->", $conteudo_usuarios, $pagina);


echo $pagina;
