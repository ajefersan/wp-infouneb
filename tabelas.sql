#
# Source for table "infouneb_blis"
#

CREATE TABLE IF NOT EXISTS `infouneb_blis` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(255) NOT NULL DEFAULT '',
  `Tipo` int(2) NOT NULL DEFAULT '0',
  `Data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Descricao` text,
  `Vagas` int(11) NOT NULL DEFAULT '0',
  `Valor` float DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Source for table "infouneb_inscricoes"
#

CREATE TABLE IF NOT EXISTS `infouneb_inscricoes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Bli` int(11) NOT NULL DEFAULT '0',
  `Usuario` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Source for table "infouneb_usuarios"
#

CREATE TABLE IF NOT EXISTS `infouneb_usuarios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL DEFAULT '',
  `Senha` varchar(255) NOT NULL DEFAULT '',
  `Nome` varchar(300) NOT NULL DEFAULT '',
  `CPF` varchar(20) NOT NULL DEFAULT '0',
  `Nascimento` date DEFAULT NULL,
  `Sexo` int(2) NOT NULL DEFAULT '0',
  `Telefone` varchar(20) DEFAULT NULL,
  `Celular` varchar(20) DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
