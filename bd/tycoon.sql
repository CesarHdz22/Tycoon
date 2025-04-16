CREATE DATABASE IF NOT EXISTS tycoon;
USE tycoon;

-- Tabla niveles
CREATE TABLE niveles (
    id_nivel INT(11) PRIMARY KEY,
    xp INT(11)
);

-- Tabla usuarios
CREATE TABLE usuarios (
    Id_Usuario INT(11) PRIMARY KEY,
    Username VARCHAR(15),
    Pass VARCHAR(10),
    correo VARCHAR(100),
    Dinero DOUBLE,
    xp INT(11),
    Id_Nivel INT(11),
    FOREIGN KEY (Id_Nivel) REFERENCES niveles(id_nivel)
);

-- Tabla objetivos
CREATE TABLE objetivos (
    Id_objetivos INT(11) PRIMARY KEY,
    nombre VARCHAR(20),
    estado BOOLEAN,
    descripcion TEXT,
    dinero DOUBLE,
    xp INT(11)
);

-- Tabla objetivos_usuarios (relación muchos a muchos)
CREATE TABLE objetivos_usuarios (
    Id_objetivos_usuarios INT(11) PRIMARY KEY,
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
    Id_Modulo INT(11) PRIMARY KEY,
    Ventas INT(11),
    Ganancia_Venta DOUBLE,
    TiempoVenta TIME,
    Nombre VARCHAR(20)
);

-- Tabla datos_jugador (relación usuario-módulo)
CREATE TABLE datos_jugador (
    Id INT(11) PRIMARY KEY,
    Id_Usuario INT(11),
    Id_Modulo INT(11),
    ventas INT(11),
    ganancia_venta DOUBLE,
    tiempo_venta INT(11),
    estado BOOLEAN,
    cantidad_ventas INT(11),
    FOREIGN KEY (Id_Usuario) REFERENCES usuarios(Id_Usuario),
    FOREIGN KEY (Id_Modulo) REFERENCES modulos(Id_Modulo)
);
