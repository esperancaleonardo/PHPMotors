<?php


class Usuario
{
  private $usuario_id;
  private $usuario_nome;
  private $usuario_email;
  private $usuario_cpf;
  private $usuario_senha;
  private $usuario_dt_nasc;
  private $usuario_tipo;

  function __construct($id, $nome, $email, $cpf, $senha, $dt_nasc, $tipo)
  {
    $this->usuario_id             = $id;
    $this->usuario_nome           = $nome;
    $this->usuario_email          = $email;
    $this->usuario_cpf            = $cpf;
    $this->usuario_senha          = $senha;
    $this->usuario_dt_nasc        = $dt_nasc;
    $this->usuario_tipo           = $tipo;
  }

  function get_usuario_id()
  {
    return $this->usuario_id;
  }
  function get_usuario_nome()
  {
    return $this->usuario_nome;
  }
  function get_usuario_email()
  {
    return $this->usuario_email;
  }
  function get_usuario_cpf()
  {
    return $this->usuario_cpf;
  }
  function get_usuario_senha()
  {
    return $this->usuario_senha;
  }
  function get_usuario_dt_nasc()
  {
    return $this->usuario_dt_nasc;
  }
  function get_usuario_tipo()
  {
    return $this->usuario_tipo;
  }
}
