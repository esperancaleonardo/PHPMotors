<?php

try{
require($_SERVER['DOCUMENT_ROOT'] . '/model/Usuario.php');
require($_SERVER['DOCUMENT_ROOT'] . '/model/Anuncio.php');    
}
catch (Exception $e){
require('./model/Usuario.php');
require('./model/Anuncio.php');    
    
}



class Database
{

  private $host;
  private $db;
  private $user;
  private $pass;
  private $charset;

  function __construct()
  {
    $this->host = 'localhost';
    $this->db   = 'id19042508_db_b2_unisale';
    $this->user = 'id19042508_root';
    $this->pass = 'ATBz%@=!3]HC#bWX';
    $this->charset = 'utf8';

    $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
    $this->options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
      $this->pdo = new PDO($this->dsn, $this->user, $this->pass, $this->options);
    } catch (PDOException $e) {
      throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
  }

  function verify_login($email, $passwd)
  {
    $query = "SELECT u.usuario_email, u.usuario_senha, tu.tipou_tipo FROM tb_usuario u INNER JOIN tb_tipo_usuario tu ON tu.tipou_id = u.usuario_tipo WHERE u.usuario_email = ?";


    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$email]);

    $data = $stmt->fetchAll();
    $output = [];
    if (sizeof($data) > 0) {

      if ($data[0]['usuario_email'] == $email and $data[0]['usuario_senha'] == md5($passwd)) {

        $output['mensagem'] = 'login efetuado com sucesso';
        $output['perfil'] = $data[0]['tipou_tipo'];
      } else {
        $output['mensagem'] = 'email ou senha não confere';
        $output['perfil'] = null;
      }
    } else {
      $output['mensagem'] = 'usuário não cadastrado';
      $output['perfil'] = null;;
    }

    return $output;
  }

  function get_user_profile($email)
  {
    $query = "SELECT * FROM tb_usuario u INNER JOIN tb_tipo_usuario tu ON tu.tipou_id = u.usuario_tipo WHERE u.usuario_email = ?";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$email]);

    $data = $stmt->fetchAll();
    return $data;
  }

  function get_all_anuncios()
  {
    $query = "SELECT tb_anuncio.*, tb_usuario.usuario_nome FROM tb_anuncio INNER JOIN tb_usuario ON anun_usuario = usuario_id ORDER BY anun_id";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute();

    $data = $stmt->fetchAll();
    return $data;
  }

  function get_all_anuncios_from_usuario($id_usuario)
  {
    $query = "SELECT tb_anuncio.*, tb_usuario.usuario_nome FROM tb_anuncio INNER JOIN tb_usuario ON anun_usuario = usuario_id WHERE usuario_id = ?";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id_usuario]);

    $data = $stmt->fetchAll();
    return $data;
  }

  function create_usuario(Usuario $usuario_cad)
  {
    $query = "INSERT INTO tb_usuario (usuario_nome, usuario_email, usuario_cpf, usuario_senha, usuario_dt_nasc, usuario_dt_cadastro, usuario_dt_atualizacao, usuario_tipo) VALUES (?, ?, ?, md5(?), ?, ?, ?, 2);";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute([
      $usuario_cad->get_usuario_nome(),
      $usuario_cad->get_usuario_email(),
      $usuario_cad->get_usuario_cpf(),
      $usuario_cad->get_usuario_senha(),
      $usuario_cad->get_usuario_dt_nasc(),
      date("Y-m-d H:i:s"),
      date("Y-m-d H:i:s")
    ]);
  }

  function create_anuncio(Anuncio $anuncio_cad)
  {
    $query = "INSERT INTO tb_anuncio (anun_titulo, anun_valor, anun_imagem, anun_descricao, anun_data, anun_ativo, anun_usuario) VALUES (?, ?, ?, ?, ?, ?, ?);";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute([
      $anuncio_cad->get_anuncio_titulo(),
      $anuncio_cad->get_anuncio_valor(),
      $anuncio_cad->get_anuncio_imagem(),
      $anuncio_cad->get_anuncio_descricao(),
      $anuncio_cad->get_anuncio_data(),
      $anuncio_cad->get_anuncio_ativo(),
      $anuncio_cad->get_anuncio_usuario(),
    ]);
  }

  function get_all_users()
  {
    $query = "SELECT u.usuario_id, u.usuario_email, u.usuario_cpf, u.usuario_dt_cadastro FROM tb_usuario u WHERE u.usuario_tipo = 2";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute();

    $data = $stmt->fetchAll();

    $users = array();
    foreach ($data as $user_data) {
      $users[] = new Usuario($user_data['usuario_id'], "", $user_data['usuario_email'], $user_data['usuario_cpf'], "", $user_data['usuario_dt_cadastro'], 1);
    }

    return $users;
  }

  function delete_usuario($user_id)
  {
    $query = "DELETE FROM tb_usuario WHERE usuario_id = " . $user_id;

    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
  }

  function delete_anuncio($anun_id)
  {
    $query = "DELETE FROM tb_anuncio WHERE anun_id = " . $anun_id;

    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
  }

  function update_usuario($user)
  {
    $query = "UPDATE tb_usuario SET usuario_nome=?, usuario_email=?, usuario_cpf=?, usuario_senha=?, usuario_dt_nasc=?, usuario_dt_atualizacao=? WHERE usuario_id =" . $user->get_usuario_id();

    $stmt = $this->pdo->prepare($query);
    $stmt->execute([
      $user->get_usuario_nome(),
      $user->get_usuario_email(),
      $user->get_usuario_cpf(),
      $user->get_usuario_senha(),
      $user->get_usuario_dt_nasc(),
      date('Y-m-d H:i:s')
    ]);
  }

  function get_usuario_by_id($id)
  {
    $query = "SELECT * FROM tb_usuario u INNER JOIN tb_tipo_usuario tu ON tu.tipou_id = u.usuario_tipo WHERE u.usuario_id = ?";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id]);

    $data = $stmt->fetchAll();
    return $data[0];
  }
}
