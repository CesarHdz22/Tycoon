
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

CREATE TABLE mejoras (
    Id_Mejora INT(11) PRIMARY KEY AUTO_INCREMENT,
    Id_Modulo INT(11),
    Tipo VARCHAR(11),
    Nombre VARCHAR(90),
    Descripcion TEXT,
    Precio INT(11),
    FOREIGN KEY (Id_Modulo) REFERENCES modulos(Id_Modulo)
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

CREATE TABLE mejoras_usuarios (
    Id_MejoraUsuario INT(11) PRIMARY KEY AUTO_INCREMENT,
    Id_Mejora INT(11),
    Estado VARCHAR(30),
    FOREIGN KEY (Id_Modulo) REFERENCES modulos(Id_Modulo),
    FOREIGN KEY (Id_Mejora) REFERENCES mejoras(Id_Mejora)
);

CREATE TABLE mejoras (
    Id_Mejora INT AUTO_INCREMENT PRIMARY KEY,
    Id_Modulo INT NOT NULL,
    Nombre VARCHAR(90) NOT NULL,
    Descripcion TEXT,
    Precio DECIMAL(10,2) NOT NULL,
    Tipo ENUM('velocidad', 'cantidad', 'ganancia') NOT NULL,
    reduccion_tiempo INT DEFAULT 0,
    ventas_por_lote INT DEFAULT 1,
    multiplicador_ganancia DECIMAL(3,1) DEFAULT 1.0,
    FOREIGN KEY (Id_Modulo) REFERENCES modulos(Id_Modulo)
);

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

INSERT INTO 

INSERT INTO usuarios VALUES
    (1,"salbador",1234,"salba@gmail.com",0,0,1),
    (2,"Magik",4321,"magicksistem32@gmail.com",0,0,1)
;

ALTER TABLE datos_jugador
ADD COLUMN tiempo_venta TIME DEFAULT '00:00:05',
ADD COLUMN cantidad_ventas INT DEFAULT 1;

INSERT INTO modulos (Id_Modulo, Nombre, Ganancia_Venta, TiempoVenta, NivelDesbloqueo) VALUES
(13, 'Módulo 13', 700.00, '00:00:17', 11),
(14, 'Módulo 14', 1000.00, '00:00:18', 12);

-- Mejoras de ejemplo
INSERT INTO mejoras (Id_Modulo, Nombre, Descripcion, Precio, Tipo, multiplicador_ganancia, reduccion_tiempo, ventas_por_lote) VALUES
(1, 'Fábrica Automatizada', 'Reduce tiempo de venta en 2 segundos', 500, 'velocidad', 1.0, 2, 1),
(1, 'Equipo de Ventas', '+2 ventas por lote', 800, 'cantidad', 1.0, 0, 2),
(1, 'Material Premium', 'Aumenta ganancia en 20%', 1200, 'ganancia', 1.2, 0, 1);

-- Objetivos de ejemplo
INSERT INTO objetivos (nombre, descripcion, Id_Modulo, dinero, xp) VALUES
('Primeras 50 ventas', 'Completa 50 ventas en el Módulo 1', 1, 200, 50),
('Eficiencia Básica', 'Reduce el tiempo de venta a 3 segundos', 1, 500, 100),
('Lote de 5', 'Realiza 5 ventas simultáneas', 1, 1000, 200);

INSERT INTO mejoras (Id_Modulo, Nombre, Descripcion, Precio, Tipo, reduccion_tiempo, ventas_por_lote, multiplicador_ganancia) VALUES
(1, 'Maquinaria rápida', 'Reduce el tiempo de venta en 1 segundo', 500.00, 'velocidad', 1, 1, 1.0),
(1, 'Equipo de ventas', 'Aumenta a 2 ventas por lote', 800.00, 'cantidad', 0, 2, 1.0),
(1, 'Material premium', 'Incrementa ganancias en 20%', 1200.00, 'ganancia', 0, 1, 1.2);