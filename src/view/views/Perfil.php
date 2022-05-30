<?php

session_start();

$pagina = file_get_contents('../templates/principal.html');
$lista_logado = file_get_contents('../templates/lista_logado.html');
$lista_nao_logado = file_get_contents('../templates/lista_nao_logado.html');
$lista_admin = file_get_contents('../templates/lista_admin.html');
$lista_nao_admin = file_get_contents('../templates/lista_nao_admin.html');
$perfil = file_get_contents('../templates/perfil.html');

include('../../model/Database.php');

$db = new Database();


if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {

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


  $usuario_logado = unserialize($_SESSION['usuario']);

  $perfil_logado = $db->get_user_profile($usuario_logado->get_usuario_email());

  $perfil = str_replace("<!--TITULONOME-->", $usuario_logado->get_usuario_nome(), $perfil);

  $form_editar = "<form action='Edicao.php' method='post' id='form_editar' name='form_editar'>
                    <input type='text' id='usuario_id_editar' name='usuario_id_editar' hidden value=" . $usuario_logado->get_usuario_id() . " ></input>
                    <button type='submit' id='submit_btn'>EDITAR</button>
                  </form>";

  $perfil = str_replace("<!--FORMEDITARUSUARIO-->", $form_editar, $perfil);


  $rows =         '<tr>
                    <td>Nome Completo</td>
                    <td colspan="4">' . $usuario_logado->get_usuario_nome() . '</td>
                  </tr>';
  $rows = $rows . '<tr>
                    <td>Email</td>
                    <td colspan="4">' . $usuario_logado->get_usuario_email() . '</td>
                  </tr>';
  $rows = $rows . '<tr>
                    <td>C.P.F.</td>
                    <td colspan="4">' . $usuario_logado->get_usuario_cpf() . '</td>
                  </tr>';
  $rows = $rows . '<tr>
                    <td>Data de Nascimento</td>
                    <td colspan="4">' . explode(' ', $usuario_logado->get_usuario_dt_nasc())[0] . '</td>
                  </tr>';
  $rows = $rows . '<tr>
                    <td>Cadastro</td>
                    <td colspan="4">' . $perfil_logado[0]['usuario_dt_cadastro'] . '</td>
                  </tr>';
  $rows = $rows . '<tr>
                    <td>Atualizado em</td>
                    <td colspan="4">' . $perfil_logado[0]['usuario_dt_atualizacao'] . '</td>
                  </tr>';
  $rows = $rows . '<tr>
                    <td>Tipo de usuário</td>
                    <td colspan="4">' . $perfil_logado[0]['tipou_tipo'] . '</td>
                  </tr>';

  $perfil = str_replace("<!--TABLEROWS-->", $rows, $perfil);

  $anuncios_usuario = $db->get_all_anuncios_from_usuario($usuario_logado->get_usuario_id());

  if (sizeof($anuncios_usuario) > 0) {

    $anuncios_usuario_conteudo = '<div style="display: flex; align-content: center; flex-wrap: wrap; gap: 2rem">';

    foreach ($anuncios_usuario as $anuncio) {
      $anuncios_usuario_conteudo .= '<div style="box-sizing: border-box; border: 1pt solid black">';
      $anuncios_usuario_conteudo .= '<img src="' . $anuncio['anun_imagem'] . '" alt="" width=300/>';

      $anuncios_usuario_conteudo .= "<form action='../../controller/deletar_anuncio.php' method='post' id='form_excluir_anuncio' name='form_excluir_anuncio'>
                                      <input type='text' id='anuncio_id_excluir' name='anuncio_id_excluir' hidden value=" . $anuncio['anun_id'] . " ></input>
                                      <button type='submit' id='submit_btn'>EXCLUIR</button>
                                    </form>";

      $anuncios_usuario_conteudo .= '<h3>' . $anuncio['anun_titulo'] . '</h3>';
      $anuncios_usuario_conteudo .= '<h4>R$ ' . number_format($anuncio['anun_valor'], 2, ",", ".") . '</h4>';
      $anuncios_usuario_conteudo .= '<h5>' . $anuncio['usuario_nome'] . '</h5>';
      $anuncios_usuario_conteudo .= '<p>' . $anuncio['anun_descricao'] . '</p>';
      $anuncios_usuario_conteudo .= '</div>';
    }

    $anuncios_usuario_conteudo .= '</div>';
  } else {
    $anuncios_usuario_conteudo = "<h2>O USUÁRIO NÃO POSSUI ANUNCIOS AINDA</h2>";
  }

  $perfil = str_replace("<!--ANUNCIOSUSUARIO-->", $anuncios_usuario_conteudo, $perfil);

  $pagina = str_replace("<!--CONTEUDO-->", $perfil, $pagina);


  echo $pagina;
} else {

  header("location: Login.php");
}
