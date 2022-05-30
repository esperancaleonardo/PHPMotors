SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: db_b2_unisale
--
CREATE DATABASE IF NOT EXISTS db_b2_unisale;
use db_b2_unisale;

CREATE TABLE db_b2_unisale.tb_tipo_usuario (
  tipou_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  tipou_tipo VARCHAR(45) NOT NULL
);

CREATE TABLE db_b2_unisale.tb_usuario (
  usuario_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  usuario_nome VARCHAR(80) NOT NULL,
  usuario_email VARCHAR(100) NOT NULL,
  usuario_cpf VARCHAR(11) NOT NULL,
  usuario_senha MEDIUMTEXT NOT NULL,
  usuario_dt_nasc DATETIME NOT NULL,
  usuario_dt_cadastro DATETIME NOT NULL,
  usuario_dt_atualizacao DATETIME NOT NULL,
  usuario_tipo INT,  /* refencia o tipo do usuario pelo ID do tipo, serve como ligação para saber o tipo de usuário */
  UNIQUE INDEX usuario_email_UNIQUE (usuario_email),
  UNIQUE INDEX usuario_cpf_UNIQUE (usuario_cpf),
  FOREIGN KEY (usuario_tipo) REFERENCES tb_tipo_usuario(tipou_id))
AUTO_INCREMENT = 1;

CREATE TABLE db_b2_unisale.tb_anuncio (
  anun_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  anun_titulo VARCHAR(100) NOT NULL,
  anun_valor FLOAT NOT NULL,
  anun_imagem MEDIUMBLOB NOT NULL,
  anun_descricao TEXT NOT NULL,
  anun_data DATETIME NOT NULL,
  anun_ativo BOOL NOT NULL,
  anun_usuario INT,  /* refencia o usuario do anuncio pelo ID do usuario, serve como ligação para saber o usuario do anuncio ou os anuncios do usuario */
  FOREIGN KEY (anun_usuario) REFERENCES tb_usuario(usuario_id))
AUTO_INCREMENT = 1;

INSERT INTO db_b2_unisale.tb_tipo_usuario (tipou_tipo) VALUES ('Admin'), ('Convencional');
INSERT INTO db_b2_unisale.tb_usuario (usuario_nome, usuario_email, usuario_cpf, usuario_senha, usuario_dt_nasc, usuario_dt_cadastro, usuario_dt_atualizacao, usuario_tipo) 
VALUES ('Administrador', 'admin', '', md5('admin@123'), '', '', '', 1);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;