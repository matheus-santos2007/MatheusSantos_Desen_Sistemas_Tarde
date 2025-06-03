create database armazena_imagem;
use armazena_imagem;





DROP TABLE IF EXISTS `armazena_imagem`.`tabela_imagem`;

CREATE TABLE `armazena_imagem`.`tabela_imagem` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `evento` VARCHAR(50) NOT NULL,
  `descricao` VARCHAR(255) NOT NULL,
  `nome_imagem` VARCHAR(500) NOT NULL,
  `tamanho_imagem` VARCHAR(25) NOT NULL,
  `tipo_imagem` VARCHAR(25) NOT NULL,
  `imagem` LONGBLOB NOT NULL,
  PRIMARY KEY (`codigo`)
);

select * from tabela_imagem;



