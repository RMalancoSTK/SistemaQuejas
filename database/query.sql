-- Active: 1675911106265@@127.0.0.1@3306@db_quejas
use db_quejas;

CREATE TABLE IF NOT EXISTS departamentos (
  iddepartamento int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  descripcion text NOT NULL,
  PRIMARY KEY (iddepartamento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS roles (
  idrol int(11) NOT NULL AUTO_INCREMENT,
  rol varchar(50) NOT NULL,
  PRIMARY KEY (idrol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS usuarios (
  idusuario int(11) NOT NULL AUTO_INCREMENT,
  idrol int(11) NOT NULL DEFAULT '2',
  iddepartamento int(11) NOT NULL,
  nombre varchar(50) NOT NULL,
  apellido varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  usuario varchar(50) NOT NULL,
  password TEXT NOT NULL,
  estado int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (idusuario),
  CONSTRAINT `fkusuariosroles` FOREIGN KEY (`idrol`) REFERENCES `roles` (`idrol`),
  CONSTRAINT `fkusuariosdepartamentos` FOREIGN KEY (`iddepartamento`) REFERENCES `departamentos` (`iddepartamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS turnos (
  idturno int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  horainicio time NOT NULL,
  horafin time NOT NULL,
  estado int(11) NOT NULL,
  PRIMARY KEY (idturno)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS categorias (
  idcategoria int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  estado int(11) NOT NULL,
  PRIMARY KEY (idcategoria)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS estados (
  idestado int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  estado int(11) NOT NULL,
  PRIMARY KEY (idestado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS quejas (
  idqueja int(11) NOT NULL AUTO_INCREMENT,
  idusuario int(11) NOT NULL,
  idcategoria int(11) NOT NULL,
  idturno int(11) NOT NULL,  
  idestado int(11) NOT NULL,
  asunto varchar(50) NOT NULL,
  descripcion text NOT NULL,
  fechacreacion datetime NOT NULL,
  fechaactualizacion datetime NOT NULL,
  estado int(11) NOT NULL,
  PRIMARY KEY (idqueja),
  CONSTRAINT fkquejasusuarios FOREIGN KEY (idusuario) REFERENCES `usuarios`(idusuario),
  CONSTRAINT fkquejascategorias FOREIGN KEY (idcategoria) REFERENCES `categorias`(idcategoria),
  CONSTRAINT fkquejasturnos FOREIGN KEY (idturno) REFERENCES `turnos`(idturno),
  CONSTRAINT fkquejasestados FOREIGN KEY (idestado) REFERENCES `estados`(idestado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE comentarios (
  idcomentario int(11) NOT NULL AUTO_INCREMENT,
  idqueja int(11) NOT NULL,
  idusuario int(11) NOT NULL,
  comentario text NOT NULL,
  fechacreacion datetime NOT NULL,
  fechaactualizacion datetime NOT NULL,
  estado int(11) NOT NULL,
  PRIMARY KEY (idcomentario),
  CONSTRAINT fkcomentariosquejas FOREIGN KEY (`idqueja`) REFERENCES `quejas`(`idqueja`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fkcomentariosusuarios FOREIGN KEY (`idusuario`) REFERENCES `usuarios`(`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS permisos (
  idpermiso int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  descripcion text NOT NULL,
  PRIMARY KEY (idpermiso)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS rolesPermisos (
  idrol int(11) NOT NULL,
  idpermiso int(11) NOT NULL,
  PRIMARY KEY (idrol,idpermiso),
  CONSTRAINT fkrolespermisosroles FOREIGN KEY (idrol) REFERENCES `roles`(idrol),
  CONSTRAINT fkrolespermisospermisos FOREIGN KEY (idpermiso) REFERENCES `permisos`(idpermiso)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `roles` (`idrol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

INSERT INTO `usuarios` (idusuario, idrol, iddepartamento, nombre, apellido, email, usuario, password, estado) VALUES
(1, 1, 1, 'Administrador', 'Administrador', 'admin@localhost', 'admin', '$2y$04$tLyTI7OutXs4oQkY7UsiauVOrF0VPhwFIpAf2zNFjeuA6OS5tR.56', 1);

INSERT INTO `turnos` (`idturno`, `nombre`, `horainicio`, `horafin`, `estado`) VALUES
(1, 'Turno A', '08:00:00', '12:00:00', 1),
(2, 'Turno B', '12:00:00', '16:00:00', 1),
(3, 'Turno C', '16:00:00', '20:00:00', 1),
(4, 'Turno D', '20:00:00', '00:00:00', 1);


INSERT INTO `categorias` (`idcategoria`, `nombre`, `estado`) VALUES
(1, 'Queja', 1),
(2, 'Sugerencia', 1),
(3, 'Felicitacion', 1);


-- insertamos los estados: pendiente, atendido, rechazado,
INSERT INTO `estados` (`idestado`, `nombre`, `estado`) VALUES
(1, 'Pendiente', 1),
(2, 'Atendido', 1),
(3, 'Rechazado', 1);


-- insertamos una queja
INSERT INTO `quejas` (`idqueja`, `idusuario`, `idcategoria`, `idturno`, `idestado`, `asunto`, `descripcion`, `fechacreacion`, `fechaactualizacion`, `estado`) VALUES
(1, 1, 1, 1, 1, 'Queja 1', 'Descripcion de la queja 1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1);

INSERT INTO `quejas` (`idqueja`, `idusuario`, `idcategoria`, `idturno`, `idestado`, `asunto`, `descripcion`, `fechacreacion`, `fechaactualizacion`, `estado`) VALUES
(2, 1, 2, 2, 2, 'Sugerencia 1', 'Descripcion de la sugerencia 1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1);

INSERT INTO `quejas` (`idqueja`, `idusuario`, `idcategoria`, `idturno`, `idestado`, `asunto`, `descripcion`, `fechacreacion`, `fechaactualizacion`, `estado`) VALUES
(3, 1, 3, 3, 3, 'Felicitacion 1', 'Descripcion de la felicitacion 1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1);

INSERT INTO `quejas` ( `idusuario`, `idcategoria`, `idturno`, `idestado`, `asunto`, `descripcion`, `fechacreacion`, `fechaactualizacion`, `estado`) VALUES
(1, 1, 4, 1, 'Queja 7', 'Descripcion de la queja 7', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1);

-- creamos la tabla de comentarios

-- insertamos un comentario
INSERT INTO `comentarios` (`idqueja`, `idusuario`, `comentario`, `fechacreacion`, `fechaactualizacion`, `estado`) VALUES
(17, 1, 'Comentario 1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1);

-- insertamos departamentos
INSERT INTO `departamentos` (`iddepartamento`, `nombre`, `descripcion`) VALUES
(1, 'Sistemas', 'Departamento de Sistemas'),
(2, 'Ventas', 'Departamento de Ventas'),
(3, 'Compras', 'Departamento de Compras'),
(4, 'Recursos Humanos', 'Departamento de Recursos Humanos'),
(5, 'Contabilidad', 'Departamento de Contabilidad'),
(6, 'Administracion', 'Departamento de Administracion'),
(7, 'Produccion', 'Departamento de Produccion'),
(8, 'Calidad', 'Departamento de Calidad'),
(9, 'Mantenimiento', 'Departamento de Mantenimiento'),
(10, 'Seguridad', 'Departamento de Seguridad'),
(11, 'Logistica', 'Departamento de Logistica'),
(12, 'Comunicaciones', 'Departamento de Comunicaciones'),
(13, 'Marketing', 'Departamento de Marketing'),
(14, 'Finanzas', 'Departamento de Finanzas'),
(15, 'Gerencia', 'Departamento de Gerencia'),
(16, 'Otros', 'Otros Departamentos');



-- insertamos los permisos
INSERT INTO `permisos` (`idpermiso`, `nombre`, `descripcion`) VALUES
(1, 'Ver Usuarios', 'Permite ver los usuarios'),
(2, 'Crear Usuarios', 'Permite crear usuarios'),
(3, 'Editar Usuarios', 'Permite editar usuarios'),
(4, 'Eliminar Usuarios', 'Permite eliminar usuarios'),
(5, 'Ver Roles', 'Permite ver los roles'),
(6, 'Crear Roles', 'Permite crear roles'),
(7, 'Editar Roles', 'Permite editar roles'),
(8, 'Eliminar Roles', 'Permite eliminar roles'),
(9, 'Ver Permisos', 'Permite ver los permisos'),
(10, 'Crear Permisos', 'Permite crear permisos'),
(11, 'Editar Permisos', 'Permite editar permisos'),
(12, 'Eliminar Permisos', 'Permite eliminar permisos'),
(13, 'Ver Departamentos', 'Permite ver los departamentos'),
(14, 'Crear Departamentos', 'Permite crear departamentos'),
(15, 'Editar Departamentos', 'Permite editar departamentos'),
(16, 'Eliminar Departamentos', 'Permite eliminar departamentos'),
(17, 'Ver Turnos', 'Permite ver los turnos'),
(18, 'Crear Turnos', 'Permite crear turnos'),
(19, 'Editar Turnos', 'Permite editar turnos'),
(20, 'Eliminar Turnos', 'Permite eliminar turnos'),
(21, 'Ver Categorias', 'Permite ver las categorias'),
(22, 'Crear Categorias', 'Permite crear categorias'),
(23, 'Editar Categorias', 'Permite editar categorias'),
(24, 'Eliminar Categorias', 'Permite eliminar categorias'),
(25, 'Ver Estados', 'Permite ver los estados'),
(26, 'Crear Estados', 'Permite crear estados'),
(27, 'Editar Estados', 'Permite editar estados'),
(28, 'Eliminar Estados', 'Permite eliminar estados'),
(29, 'Ver Quejas', 'Permite ver las quejas'),
(30, 'Crear Quejas', 'Permite crear quejas'),
(31, 'Editar Quejas', 'Permite editar quejas'),
(32, 'Eliminar Quejas', 'Permite eliminar quejas'),
(33, 'Ver Comentarios', 'Permite ver los comentarios'),
(34, 'Crear Comentarios', 'Permite crear comentarios'),
(35, 'Editar Comentarios', 'Permite editar comentarios'),
(36, 'Eliminar Comentarios', 'Permite eliminar comentarios');

-- insertamos los rolespermisos
INSERT INTO `rolespermisos` (`idrol`, `idpermiso`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(2, 35),
(2, 36);

SELECT q.idqueja,u.nombre AS usuario, d.nombre AS departamento, q.asunto, q.fechacreacion, e.nombre AS estado
FROM quejas q
INNER JOIN estados e ON q.idestado = e.idestado
INNER JOIN usuarios u ON q.idusuario = u.idusuario
INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
ORDER BY q.fechacreacion DESC
LIMIT 5;

SELECT DAY(fechacreacion) AS dia, COUNT(*) AS total 
FROM quejas 
WHERE fechacreacion BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND DATE_FORMAT(LAST_DAY(NOW()),'%Y-%m-%d')
AND idestado = 2
GROUP BY dia;

-- insertamos una queja y un comentario
INSERT INTO `quejas` (`idqueja`, `idusuario`, `idestado`, `idcategoria`, `idturno`, `asunto`, `descripcion`, `fechacreacion`, `fechaactualizacion`, `estado`) VALUES
(1, 1, 1, 1, 1, 'Asunto 1', 'Descripcion 1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1);

INSERT INTO `comentarios` (`idcomentario`, `idqueja`, `idusuario`, `comentario`, `fechacreacion`, `fechaactualizacion`, `estado`) VALUES
(1, 1, 1, 'Comentario 1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1);

SELECT dates.dia, COALESCE(total, 0) AS total_quejas
FROM (
  SELECT DAY(DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-01'), INTERVAL (tens.n * 10 + ones.n - 1) DAY)) AS dia
  FROM
    (SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) ones,
    (SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) tens
  WHERE DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-01'), INTERVAL (tens.n * 10 + ones.n - 1) DAY) <= LAST_DAY(NOW())
) AS dates
LEFT JOIN (
  SELECT DAY(fechacreacion) AS dia, COUNT(*) AS total
  FROM quejas
  WHERE fechacreacion BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND DATE_FORMAT(LAST_DAY(NOW()),'%Y-%m-%d')
  AND idestado = $idestado
  GROUP BY dia
) AS quejas ON dates.dia = quejas.dia
ORDER BY dates.dia;
