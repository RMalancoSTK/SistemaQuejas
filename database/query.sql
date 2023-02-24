-- Active: 1675911106265@@127.0.0.1@3306@db_quejas

-- creamos la tabla de usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` TEXT NOT NULL,
  `idrol` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
    PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- creamos la tabla de roles
CREATE TABLE IF NOT EXISTS `roles` (
  `idrol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(50) NOT NULL,
    PRIMARY KEY (`idrol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- insertamos los roles
INSERT INTO `roles` (`idrol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- insertamos un usuario administrador
INSERT INTO `usuarios` (`idusuario`, `nombre`, `apellido`, `email`, `usuario`, `password`, `idrol`, `estado`) VALUES
(1, 'Administrador', 'Administrador', 'admin@localhost', 'admin', '$2y$04$tLyTI7OutXs4oQkY7UsiauVOrF0VPhwFIpAf2zNFjeuA6OS5tR.56', 1, 1);