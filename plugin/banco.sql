
CREATE TABLE `infouneb_blis` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(255) NOT NULL DEFAULT '',
  `Ministrante` varchar(255) NOT NULL DEFAULT '',
  `Tipo` int(2) NOT NULL DEFAULT '0',
  `Grupo` int(11) NOT NULL DEFAULT '0',
  `Vagas` int(11) NOT NULL DEFAULT '0',
  `Valor` float DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `infouneb_blis` VALUES (1,'Desenvolvimento Android','Raul Abreu e Felipe Piñeiro',2,0,20,15),(2,'Unity3D','Jesse Nery (Comunidades Virtuais)',2,0,20,15),(3,'HTML 5 para iniciantes','Caio Nascimento',2,1,20,15),(4,'Front-end','Shankar Cabus',2,1,20,15),(5,'Robótica Epigenética','Rodrigo Guerra',1,0,20,15),(6,'Visão Computacional','José Grimaldo',1,0,20,15),(7,'Startup’s','Bruno Vinícius',1,1,20,15),(8,'Minicurso Surpresa','Surpresa',1,1,20,15);

CREATE TABLE `infouneb_inscricoes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Bli` int(11) NOT NULL DEFAULT '0',
  `Usuario` int(11) NOT NULL DEFAULT '0',
  `Status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `infouneb_maratona` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(255) DEFAULT NULL,
  `Lider` varchar(20) NOT NULL DEFAULT '',
  `Membro1` varchar(20) DEFAULT NULL,
  `Membro2` varchar(20) DEFAULT NULL,
  `MembroReserva` varchar(20) DEFAULT NULL,
  `Status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `infouneb_palestras` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(255) NOT NULL DEFAULT '',
  `Ministrante` varchar(255) NOT NULL DEFAULT '',
  `Data` date NOT NULL DEFAULT '0000-00-00',
  `HoraInicio` time NOT NULL DEFAULT '00:00:00',
  `HoraFim` time NOT NULL DEFAULT '00:00:00',
  `Obs` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `infouneb_palestras` VALUES (1,'Idéias em Ação!','Cláudio Amorim','2014-11-24','10:00:00','11:00:00','Palestra de Abertura'),(2,'Organização do Setor de TI','Rubén Delgado','2014-11-24','11:20:00','12:20:00',NULL),(3,'Front-end','Shankar Cabus','2014-11-25','08:00:00','10:00:00',NULL),(4,'Muito Além do PC: As novas fronteiras de integração de Hardware-Software','Victor Ben-Hur','2014-11-25','10:20:00','12:20:00',NULL),(5,'Competências Profissionais','Zaíra Vasconcelos','2014-11-26','08:00:00','10:00:00',NULL),(6,'Business Intelligence - A Serviço do suporte decisório nas organizações','Grimaldo Lopes de Oliveira','2014-11-26','10:20:00','12:20:00',NULL),(7,'CAMS: Cloud, Analitics (Big Data), Mobile e Social','Carla Castro','2014-11-27','08:00:00','10:00:00',NULL),(8,'Em busca da Produtividade: Como as organizações podem alcançar a excelência na prestação de serviços aos clientes e cidadãos','José Luís Sid','2014-11-27','10:20:00','12:20:00',NULL);

CREATE TABLE `infouneb_usuarios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL DEFAULT '',
  `Nome` varchar(300) NOT NULL DEFAULT '',
  `CPF` varchar(20) NOT NULL DEFAULT '0',
  `Nascimento` varchar(100) NOT NULL DEFAULT '',
  `Sexo` int(2) NOT NULL DEFAULT '0',
  `Profissional` int(11) NOT NULL,
  `Titulo` int(11) NOT NULL,
  `Area` varchar(255) NOT NULL,
  `Telefone` varchar(20) DEFAULT NULL,
  `Celular` varchar(20) DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  `InscricaoData` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;