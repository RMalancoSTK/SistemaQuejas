-- Active: 1675911106265@@127.0.0.1@3306@db_quejas
use db_quejas;

-- crear la base de datos db_quejas
CREATE DATABASE IF NOT EXISTS db_quejas DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;


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




--crear la tabla de archivos
CREATE TABLE archivos (
  idarchivo int(11) NOT NULL AUTO_INCREMENT,
  idqueja int(11) NOT NULL,
  nombrearchivo varchar(50) NOT NULL,
  tipoarchivo varchar(50) NOT NULL,
  tamanoarchivo int(11) NOT NULL,
  ruta varchar(50) NOT NULL,
  fechacreacion datetime NOT NULL,
  fechaactualizacion datetime NOT NULL,
  estado int(11) NOT NULL,
  PRIMARY KEY (idarchivo),
  CONSTRAINT fkarchivosquejas FOREIGN KEY (`idqueja`) REFERENCES `quejas`(`idqueja`) ON UPDATE CASCADE ON DELETE CASCADE
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

INSERT INTO `usuarios` (idrol, iddepartamento, nombre, apellido, email, usuario, password, estado) 
VALUES ( 1, 1, 'Administrador', 'Administrador', 'admin@localhost', 'admin', '$2y$04$tLyTI7OutXs4oQkY7UsiauVOrF0VPhwFIpAf2zNFjeuA6OS5tR.56', 1);

-- ACTUALIZAR DATOS USUARIO idrol, iddepartamento, nombre, apellido, email, usuario, password, estado
UPDATE usuarios SET 
idrol = 1, 
iddepartamento = 1, 
nombre = 'Administrador', 
apellido = 'Administrador', 
email = 'admin@localhost', 
usuario = 'admin', 
password = '$2y$04$tLyTI7OutXs4oQkY7UsiauVOrF0VPhwFIpAf2zNFjeuA6OS5tR.56', 
estado = 1
WHERE idusuario = 1;

-- el mismo query de update pero que compare si es el administrador no hacer el cambio
UPDATE usuarios SET
idrol = 1,
iddepartamento = 1,
nombre = 'Administrador',
apellido = 'Administrador',
email = 'admin@localhost',
usuario = 'admin',
password = '$2y$04$tLyTI7OutXs4oQkY7UsiauVOrF0VPhwFIpAf2zNFjeuA6OS5tR.56',
estado = 1
WHERE idusuario = 2 AND idusuario <> 1;


-- registrar un usuario
INSERT INTO `usuarios` ( idrol, iddepartamento, nombre, apellido, email, usuario, password, estado) VALUES
( 2, 1, 'Usuario', 'Usuario', 'usuario@localhost', 'usuario', '$2y$04$tLyTI7OutXs4oQkY7UsiauVOrF0VPhwFIpAf2zNFjeuA6OS5tR.56', 1);

SELECT * FROM usuarios;

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
INSERT INTO comentarios (idqueja, idusuario, comentario, fechacreacion, fechaactualizacion, estado) 
VALUES (1, 1, 'Comentario 1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1);

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


INSERT INTO `comentarios` (`idqueja`, `idusuario`, `comentario`, `fechacreacion`, `fechaactualizacion`, `estado`) VALUES
( 18, 1, 'Comentario 1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1);


SELECT q.idqueja,u.nombre AS usuario, d.nombre AS departamento, q.asunto, q.fechacreacion, e.nombre AS estado
FROM quejas q
INNER JOIN estados e ON q.idestado = e.idestado
INNER JOIN usuarios u ON q.idusuario = u.idusuario
INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
ORDER BY q.fechacreacion DESC
LIMIT 5;

SELECT numeros.dia AS dia, 
    COALESCE(COUNT(CASE WHEN quejas.idestado = 1 THEN quejas.idqueja END), 0) AS totalpendientes,
    COALESCE(COUNT(CASE WHEN quejas.idestado = 2 THEN quejas.idqueja END), 0) AS totalatendidas,
    COALESCE(COUNT(CASE WHEN quejas.idestado = 3 THEN quejas.idqueja END), 0) AS totalrechazadas
FROM (
  SELECT 1 AS dia UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION
  SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 UNION
  SELECT 13 UNION SELECT 14 UNION SELECT 15 UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION
  SELECT 19 UNION SELECT 20 UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION
  SELECT 25 UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30 UNION
  SELECT 31
) AS numeros
LEFT JOIN quejas ON DAY(quejas.fechacreacion) = numeros.dia
WHERE numeros.dia <= DAY(LAST_DAY(NOW()))
GROUP BY numeros.dia;

SELECT * 
FROM usuarios u
INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
WHERE usuario = 'admin';


SELECT u.idusuario, CONCAT(u.nombre, ' ', u.apellido) AS nombre, u.usuario, u.password, u.email, u.estado, d.nombre AS departamento, r.rol AS rol, u.idrol
FROM usuarios u
INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
INNER JOIN roles r ON u.idrol = r.idrol
WHERE usuario = 'admin';

SELECT * FROM categorias 
WHERE estado = 1;

SELECT * FROM turnos WHERE estado = 1;

SELECT numeros.dia AS dia,
COALESCE(COUNT(CASE WHEN quejas.idestado = 1 THEN quejas.idqueja END), 0) AS totalpendientes,
COALESCE(COUNT(CASE WHEN quejas.idestado = 2 THEN quejas.idqueja END), 0) AS totalatendidas,
COALESCE(COUNT(CASE WHEN quejas.idestado = 3 THEN quejas.idqueja END), 0) AS totalrechazadas
FROM (
SELECT 1 AS dia UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION
SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 UNION
SELECT 13 UNION SELECT 14 UNION SELECT 15 UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION
SELECT 19 UNION SELECT 20 UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION
SELECT 25 UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30 UNION
SELECT 31
) AS numeros
LEFT JOIN quejas ON DAY(quejas.fechacreacion) = numeros.dia AND MONTH(quejas.fechacreacion) = MONTH(NOW())
WHERE numeros.dia <= DAY(LAST_DAY(NOW()))
GROUP BY numeros.dia;



SELECT q.idqueja AS Id, DATE_FORMAT(q.fechacreacion, '%d/%m/%Y') AS Fecha, CONCAT(u.nombre, ' ', u.apellido) AS 'Quien Registra',q.asunto as Asunto, d.nombre AS Departamento, c.nombre AS Tipo, e.nombre AS Estado, q.estado AS EstadoId
FROM quejas q
INNER JOIN usuarios u ON q.idusuario = u.idusuario
INNER JOIN categorias c ON q.idcategoria = c.idcategoria
INNER JOIN estados e ON q.idestado = e.idestado
INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
WHERE u.idusuario = 1
ORDER BY q.fechacreacion DESC;

SELECT q.idqueja AS Id, DATE_FORMAT(q.fechacreacion, '%d/%m/%Y') AS Fecha, CONCAT(u.nombre, ' ', u.apellido) AS 'Quien Registra',q.asunto as Asunto, d.nombre AS Departamento, c.nombre AS Tipo, e.nombre AS Estado, q.estado AS EstadoId
FROM quejas q
INNER JOIN usuarios u ON q.idusuario = u.idusuario
INNER JOIN categorias c ON q.idcategoria = c.idcategoria
INNER JOIN estados e ON q.idestado = e.idestado
INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
ORDER BY q.fechacreacion DESC;

SELECT u.idusuario, u.usuario, u.nombre, u.email as correo, r.rol AS rol, u.estado
        FROM usuarios u
        INNER JOIN roles r ON u.idrol = r.idrol
        WHERE u.idusuario <> 1;

        SELECT q.idqueja, q.idusuario, q.idestado, q.idcategoria, q.idturno, q.asunto, q.descripcion, q.fechacreacion, q.fechaactualizacion, q.estado,
        u.nombre AS usuario, d.nombre AS departamento, c.nombre AS categoria, t.nombre AS turno, e.nombre AS estado, CONCAT(u.nombre, ' ', u.apellido) AS nombrecompleto
        FROM quejas q
        INNER JOIN usuarios u ON q.idusuario = u.idusuario
        INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
        INNER JOIN categorias c ON q.idcategoria = c.idcategoria
        INNER JOIN turnos t ON q.idturno = t.idturno
        INNER JOIN estados e ON q.idestado = e.idestado
        WHERE q.idqueja = 18;

SELECT c.idcomentario, c.comentario, 
       CONCAT(DATE_FORMAT(c.fechacreacion, '%h:%i %p'), ' ', 
              IF(DATE(c.fechacreacion) = DATE(NOW()), 'Hoy', DATE_FORMAT(c.fechacreacion, '%d %b %Y'))) AS Fecha,
       CONCAT(u.nombre, ' ', u.apellido) AS 'Quien Comenta'
FROM comentarios c
INNER JOIN usuarios u ON c.idusuario = u.idusuario
WHERE c.idqueja = 55
ORDER BY c.fechacreacion DESC;

SELECT COUNT(*) AS total
FROM comentarios c
INNER JOIN usuarios u ON c.idusuario = u.idusuario
WHERE c.idqueja = 55
ORDER BY c.fechacreacion DESC;

SELECT a.idarchivo, a.nombrearchivo, a.ruta, a.tipoarchivo, a.estado
        FROM archivos a
        WHERE a.idqueja = 55;

-- borrar duplicados en la tabla archivos
DELETE a1 FROM archivos a1, archivos a2
WHERE a1.idarchivo < a2.idarchivo AND a1.nombrearchivo = a2.nombrearchivo;

INSERT INTO `archivos` (idqueja, nombrearchivo, tipoarchivo, tamanoarchivo, ruta, fechacreacion, fechaactualizacion, estado) 
VALUES (55, 'archivo1.jpg', 'image/jpeg', 12345, 'uploads/quejas/55/archivo1.jpg', NOW(), NOW(), 1);

-- alterar el query anterior si el archivo ya existe en el idqueja no se inserta
INSERT INTO `archivos` (idqueja, nombrearchivo, tipoarchivo, tamanoarchivo, ruta, fechacreacion, fechaactualizacion, estado)
SELECT 55, 'archivo1.jpg', 'image/jpeg', 12345, 'uploads/quejas/55/archivo1.jpg', NOW(), NOW(), 1
WHERE NOT EXISTS (SELECT * FROM archivos WHERE idqueja = 55 AND nombrearchivo = 'archivo1.jpg');

-- listado de usuarios para el datatable de usuarios
-- datos requeridos: usuario, nombre, apellido, departamento, rol, estado
SELECT u.idusuario, u.usuario, u.nombre, u.apellido, d.nombre AS departamento, r.rol AS rol, u.estado
FROM usuarios u
INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
INNER JOIN roles r ON u.idrol = r.idrol
WHERE u.idusuario <> 1;
-- con el query aseguramos de que no se muestre el usuario administrador para que no se pueda eliminar

SELECT * FROM departamentos;

SELECT * FROM roles;

SELECT u.idusuario, u.idrol, u.iddepartamento, u.nombre, u.apellido, u.email, u.usuario, u.password, u.estado
FROM usuarios u
WHERE u.idusuario = 2;

SELECT u.idusuario, CONCAT(u.nombre, ' ', u.apellido) AS nombre, u.usuario, u.password, u.email, u.estado, d.nombre AS departamento, r.rol AS rol, u.idrol
FROM usuarios u
INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
INNER JOIN roles r ON u.idrol = r.idrol
WHERE u.idusuario = 1;
