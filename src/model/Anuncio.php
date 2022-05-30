<?php

class Anuncio
{
  private $anuncio_id;
  private $anuncio_titulo;
  private $anuncio_valor;
  private $anuncio_imagem;
  private $anuncio_descricao;
  private $anuncio_data;
  private $anuncio_ativo;
  private $anuncio_usuario;

  function __construct($id, $titulo, $valor, $imagem, $desc, $data, $ativo, $usuario)
  {
    $this->anuncio_id = $id;
    $this->anuncio_titulo = $titulo;
    $this->anuncio_valor = $valor;
    $this->anuncio_imagem = $imagem;
    $this->anuncio_descricao = $desc;
    $this->anuncio_data = $data;
    $this->anuncio_ativo = $ativo;
    $this->anuncio_usuario = $usuario;
  }

  function get_anuncio_id()
  {
    return $this->anuncio_id;
  }
  function get_anuncio_titulo()
  {
    return $this->anuncio_titulo;
  }
  function get_anuncio_valor()
  {
    return $this->anuncio_valor;
  }
  function get_anuncio_imagem()
  {
    return $this->anuncio_imagem;
  }
  function get_anuncio_descricao()
  {
    return $this->anuncio_descricao;
  }
  function get_anuncio_data()
  {
    return $this->anuncio_data;
  }
  function get_anuncio_ativo()
  {
    return $this->anuncio_ativo;
  }
  function get_anuncio_usuario()
  {
    return $this->anuncio_usuario;
  }
}
