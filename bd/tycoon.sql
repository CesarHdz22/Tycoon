CREATE DATABASE IF NOT EXISTS tycoon;
USE tycoon;

-- Tabla niveles
CREATE TABLE niveles (
    id_nivel INT(11) PRIMARY KEY AUTO_INCREMENT,
    xp INT(11)
);


-- Tabla usuarios     
CREATE TABLE usuarios (
    Id_Usuario INT(11) PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(15),
    Pass VARCHAR(255),
    correo VARCHAR(100),
    Dinero DOUBLE DEFAULT 0,
    xp INT DEFAULT 0,
    Id_Nivel INT DEFAULT 1
    FOREIGN KEY (Id_Nivel) REFERENCES niveles(id_nivel)
);


-- Tabla objetivos
CREATE TABLE objetivos (
    Id_objetivos INT(11) PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(20),
    estado BOOLEAN,
    descripcion TEXT,
    dinero DOUBLE,
    xp INT(11)
);



-- Tabla objetivos_usuarios (relación muchos a muchos)
CREATE TABLE objetivos_usuarios (
    Id_objetivos_usuarios INT(11) PRIMARY KEY AUTO_INCREMENT,
    Id_Usuario INT(11),
    Id_objetivos INT(11),
    dinero_ganado DOUBLE,
    xp_ganado INT(11),
    estado BOOLEAN,
    FOREIGN KEY (Id_Usuario) REFERENCES usuarios(Id_Usuario),
    FOREIGN KEY (Id_objetivos) REFERENCES objetivos(Id_objetivos)
);

-- Tabla modulos
CREATE TABLE modulos (
    Id_Modulo INT(11) PRIMARY KEY AUTO_INCREMENT,
    Ventas INT(11),
    Ganancia_Venta DOUBLE,
    TiempoVenta TIME,
    Nombre VARCHAR(20),
    GananciaTotal DOUBLE,
    NivelDesbloqueo INT(11)
);

-- Tabla datos_jugador (relación usuario-módulo)
CREATE TABLE datos_jugador (
    Id INT(11) PRIMARY KEY AUTO_INCREMENT,
    Id_Usuario INT(11),
    Id_Modulo INT(11),
    ventas INT(11),
    ganancia_venta DOUBLE,
    TiempoVenta TIME,
    Nombre VARCHAR(50),
    GananciaTotal DOUBLE,
    NivelDesbloqueo INT(11),
    estado BOOLEAN,
    cantidad_ventas INT(11),
    FOREIGN KEY (Id_Usuario) REFERENCES usuarios(Id_Usuario),
    FOREIGN KEY (Id_Modulo) REFERENCES modulos(Id_Modulo)
);

--extraer ventas, tiempo ventas y precio 
--DATOS BASE
--MEJORAS, cambian los datos de iempo, costo de venta
--cuando se crea un usuario todos los datos de MODILOS se mete a "datos jugador", se meten los 3 primeros modulos en estado true, cantidad de ventas en 
INSERT INTO modulos VALUES
(1, 0, 5.00, '00:00:05', 'Modulo 1',0.0, 1),
(2, 0, 10.00, '00:00:06', 'Modulo 2',0.0, 1),
(3, 0, 15.00, '00:00:07', 'Modulo 3',0.0, 1),
(4, 0, 25.00, '00:00:08', 'Modulo 4',0.0, 3),
(5, 0, 40.00, '00:00:09', 'Modulo 5',0.0, 4),
(6, 0, 60.00, '00:00:10', 'Modulo 6',0.0, 5),
(7, 0, 90.00, '00:00:11', 'Modulo 7',0.0, 6),
(8, 0, 120.00, '00:00:12', 'Modulo 8',0.0, 7),
(9, 0, 160.00, '00:00:13', 'Modulo 9',0.0, 8),
(10, 0, 210.00, '00:00:14', 'Modulo 10',0.0, 9),
(11, 0, 300.00, '00:00:15', 'Modulo 11',0.0, 10),
(12, 0, 500.00, '00:00:16', 'Modulo 12',0.0, 10)
;

INSERT INTO niveles VALUES 
    (1,249),
    (2,499),
    (3,999),
    (4,1999),
    (5,2999),
    (6,3999),
    (7,4999),
    (8,5999),
    (9,6999),
    (10,7999)
;

INSERT INTO usuarios VALUES
    (1,"salbador",1234,"salba@gmail.com",0,0,1),
    (2,"sexsaar",4321,"magicksistem32@gmail.com",0,0,1)
;


--en codigo cuando se registre un usuario, se manda a bd se creen los datos de modulos (ARRIBA) y se agrega el id usuario 3 primeros modulos en truw y cantidad de ventas en 0  REGISTER.PHP

