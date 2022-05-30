<?php

session_start();

include('../model/Database.php');

$db = new Database();

if (isset($_POST['email']) && isset($_POST['senha'])) {
  $email_acesso = $_POST['email'];
  $senha_acesso = $_POST['senha'];

  $verificacao = $db->verify_login($email_acesso, $senha_acesso);

  if (strcmp($verificacao['mensagem'], 'login efetuado com sucesso') == 0) {
    $_SESSION['logado'] = true;

    if (strcmp($verificacao['perfil'], 'Admin') == 0) {
      $_SESSION['admin'] = true;
    } else {
      $_SESSION['admin'] = false;
    }


    $dados = $db->get_user_profile($email_acesso)[0];

    $usuario = new Usuario(
      $dados['usuario_id'],
      $dados['usuario_nome'],
      $dados['usuario_email'],
      $dados['usuario_cpf'],
      $dados['usuario_senha'],
      $dados['usuario_dt_nasc'],
      $dados['tipou_tipo']
    );

    $_SESSION['usuario'] = serialize($usuario);

    header("location: ../view/views/home.php");
    exit();
  } else {
    header("location: ../view/views/Login.php");
    exit();
  }
} else {
  header("location: ../view/views/Login.php");
  exit();
}
