
CREATE TABLE `locais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `tipo` enum('Capital','Turismo') NOT NULL,
  PRIMARY KEY (`id`)
);


INSERT INTO `locais` VALUES
(1,'Aracaju','Brasil','Capital'),
(2,'Belém','Brasil','Capital'),
(3,'Belo Horizonte','Brasil','Capital'),
(4,'Boa Vista','Brasil','Capital'),
(5,'Brasília','Brasil','Capital'),
(6,'Campo Grande','Brasil','Capital'),
(7,'Cuiabá','Brasil','Capital'),
(8,'Curitiba','Bra(il','Capital'),
(9,'Florianópolis','Brasil','Capital'),
(10,'Fortaleza','Brasil','Capital'),
(11,'Goiânia','Brasil','Capital'),
(12,'João Pessoa','Brasil','Capital'),
(13,'Macapá','Brasil','Capital'),
(14,'Maceió','Brasil','Capital'),
(15,'Manaus','Brasil','Capital'),
(16,'Natal','Brasil','Capital'),
(17,'Palmas','Brasil','Capital'),
(18,'Porto Alegre','Brasil','Capital'),
(19,'Porto Velho','Brasil','Capital'),
(20,'Recife','Brasil','Capital'),
(21,'Rio Branco','Brasil','Capital'),
(22,'Rio de Janeiro','Brasil','Capital'),
(23,'Salvador','Brasil','Capital'),
(24,'São Luís','Brasil','Capital'),
(25,'São Paulo','Brasil','Capital'),
(26,'Teresina','Brasil','Capital'),
(27,'Vitória','Brasil','Capital'),
(28,'Buenos Aires','Argentina','Turismo'),
(29,'Santiago','Chile','Turismo'),
(30,'Lima','Peru','Turismo'),
(31,'Bogotá','Colômbia','Turismo'),
(32,'Orlando','EUA','Turismo'),
(33,'Nova York','EUA','Turismo'),
(34,'Cancún','México','Turismo'),
(35,'Cidade do Panamá','Panamá','Turismo');

CREATE TABLE `voos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `origem_id` int(11) NOT NULL,
  `destino_id` int(11) NOT NULL,
  `preco_base` decimal(10,2) NOT NULL,
  `data_voo` date NOT NULL,
  `horario` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `origem_id` (`origem_id`),
  KEY `destino_id` (`destino_id`),
  CONSTRAINT `voos_ibfk_1` FOREIGN KEY (`origem_id`) REFERENCES `locais` (`id`),
  CONSTRAINT `voos_ibfk_2` FOREIGN KEY (`destino_id`) REFERENCES `locais` (`id`)
);

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voo_ida_id` int(11) NOT NULL,
  `voo_volta_id` int(11) DEFAULT NULL,
  `qtd_adultos` int(11) NOT NULL,
  `qtd_criancas` int(11) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `status` enum('Confirmada','Cancelada') DEFAULT 'Confirmada',
  PRIMARY KEY (`id`),
  KEY `voo_ida_id` (`voo_ida_id`),
  KEY `voo_volta_id` (`voo_volta_id`),
  CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`voo_ida_id`) REFERENCES `voos` (`id`),
  CONSTRAINT `agendamentos_ibfk_2` FOREIGN KEY (`voo_volta_id`) REFERENCES `voos` (`id`)
);


