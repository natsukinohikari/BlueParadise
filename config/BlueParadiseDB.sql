CREATE DATABASE IF NOT EXISTS `blueparadise`;
USE `blueparadise`;

CREATE TABLE IF NOT EXISTS CAMAROTES ( 
     id_camarote INT(5) NOT NULL AUTO_INCREMENT, 
     numerocamas INT(2) NOT NULL , 
     descripcion VARCHAR(255) NOT NULL,
     coste INT(3) NOT NULL,
     PRIMARY KEY(id_camarote)
) ENGINE=InnoDB;

ALTER TABLE CAMAROTES
    AUTO_INCREMENT=1000;

INSERT INTO CAMAROTES (numerocamas, descripcion, coste) VALUES
(1, "Habitación simple", 9),
(1, "Habitación simple con nevera", 11),
(1, "Habitación simple con terraza", 14),
(1, "Habitación simple con terraza y nevera", 19),
(2, "Habitación doble", 14),
(2, "Habitación doble con nevera", 19),
(2, "Habitación doble con terraza", 24),
(2, "Habitación doble con terraza y nevera", 29),
(1, "Habitación grande de una sola cama con terraza, jacuzzi y mueble-bar", 39),
(3, "Habitación grande", 29),
(2, "Habitación grande con jacuzzi y mueble-bar", 34),
(3, "Habitación grande con terraza y mueble-bar", 31);

CREATE TABLE IF NOT EXISTS CRUCEROS ( 
     id_crucero INT(5) NOT NULL AUTO_INCREMENT,
     nombre VARCHAR(100) NOT NULL,
     descripcion VARCHAR(255) NOT NULL,
     PRIMARY KEY(id_crucero)
) ENGINE=InnoDB;

ALTER TABLE CRUCEROS
    AUTO_INCREMENT=100;

INSERT INTO CRUCEROS (nombre, descripcion) VALUES
("Miguel Segundo", "Crucero ideal para pasar unas pequeñas vacaciones exóticas."),
("Jordi Mari", "Crucero diversas actividades de ocio."),
("Pólemos agazos", "Crucero donde se disfrutará de unas relajantes y apasionantes vacaciones con múltiples actividades de ocio."),
("Salomón Sans", "Crucero con una gran variedad de ocio."),
("Mare Jivari", "Crucero con apasionantes ofertas de ocio y gastronómicas.");

CREATE TABLE IF NOT EXISTS CAMAROTES_CRUCEROS ( 
	 id_camarote_crucero INT(4) NOT NULL AUTO_INCREMENT,
     id_camarote INT(5) NOT NULL, 
     id_crucero INT(5) NOT NULL,
     cantidad INT(3) NOT NULL,
     PRIMARY KEY (id_camarote_crucero),
     UNIQUE KEY (id_camarote, id_crucero)
) ENGINE=InnoDB;
    
INSERT INTO CAMAROTES_CRUCEROS (id_camarote, id_crucero, cantidad) VALUES
(1000, 100, 25), (1001, 100, 10), (1004, 100, 20), (1005, 100, 10), (1009, 100, 5), (1011, 100, 5),
(1003, 101, 20), (1006, 101, 20), (1007, 101, 20), (1008, 101, 2), (1009, 101, 10), (1010, 101, 5), (1011, 101, 10),
(1002, 102, 20), (1003, 102, 10), (1004, 102, 20), (1005, 102, 10), (1007, 102, 18), (1009, 102, 12), (1011, 102, 7),
(1003, 103, 15), (1007, 103, 30), (1008, 103, 5), (1009, 103, 10), (1010, 103, 10), 
(1002, 104, 15), (1003, 104, 25), (1005, 104, 10), (1006, 104, 5), (1007, 104, 20), (1008, 104, 5), (1009, 104, 10), (1010, 104, 5), (1011, 104, 5);
    
CREATE TABLE IF NOT EXISTS ZONAS ( 
     id_zona INT(5) NOT NULL AUTO_INCREMENT, 
     lugar VARCHAR(255) NOT NULL,
     PRIMARY KEY(id_zona)
) ENGINE=InnoDB;

INSERT INTO ZONAS (lugar) VALUES
("Atlántico"),
("España"),
("Mediterráneo");

CREATE TABLE IF NOT EXISTS RUTAS ( 
     id_ruta INT(5) NOT NULL AUTO_INCREMENT, 
     itinerario VARCHAR(255) NOT NULL,
     descripcion VARCHAR(255) NOT NULL,
     coste INT(4) NOT NULL,
     PRIMARY KEY(id_ruta),
     id_zona INT(5) NOT NULL
) ENGINE=InnoDB;

INSERT INTO RUTAS (itinerario, descripcion, coste, id_zona) VALUES
("Donostia-Bilbao-Santander-Gijón-La Coruña-Vigo", "Viaje por las principales ciudades del norte español desde Donostia hasta Vigo", 59, 1),
("Cádiz-Málaga-Valencia-Mallorca-Barcelona", "Viaje por las principales ciudades del mediterráneo desde Cádiz hasta Barcelona", 79, 3),
("Bilbao-Gijón-Vigo-Cádiz-Tenerife-Las Palmas-Málaga-Mallorca-Barcelona-Valencia", "Viaje por las principales ciudades de la costa española", 149, 2),
("Génova-Fiumicino-Nápoles-Palermo-Catania-Bari-Pescara-Venecia", "Viaje por la costa italiana", 99, 3),
("Kavala-Salónica-Atenas-Heraclión-Patras", "Viaje por la costa griega", 99, 3),
("Tánger-Orán-Argel-Túnez-Trípoli-Bengasi-Alejandría-Tel Aviv-Beirut-Nicosia-Mersin", "Viaje por el norte de África hasta el este del Mediterráneo", 149, 3),
("Barcelona-Málaga-Argel-Túnez-Alejandría-Beirut-Antalya-Esmirna-Salónica-Atenas-Patras-Vlorë-Split-Venecia-Bari-Catania-Cagliari-Nápoles-Génova-Niza-Marsella-Mallorca", "Viaje por todo el mar Mediterráneo", 349, 3),
("Vigo-Bilbao-La Rochelle-Brest-Cork-Dublín-Liverpool-Brighton-La Haya-Hamburgo", "Viaje por el Atlántico europeo", 179, 1),
("Aberdeen-Edimburgo-Sunderland-Kingston-Southend-Portsmouth-Cardiff-Cork-Dublín-Liverpool-Belfast", "Viaje por las islas británicas", 149, 1),
("Oslo-Copenhague-Kaliningrado-Riga-Tallin-San Petersburgo-Helsinki-Oulu-Turku-Estocolmo-Klaipéda-Gdansk-Malmö", "Viaje por el báltico", 149, 1);

CREATE TABLE IF NOT EXISTS CRUCEROS_RUTAS (
	 id_crucero_ruta INT(4) NOT NULL AUTO_INCREMENT,
     id_crucero INT(5) NOT NULL, 
     id_ruta INT(5) NOT NULL,
     salida DATE NOT NULL,
     llegada DATE NOT NULL,
     PRIMARY KEY (id_crucero_ruta),
     UNIQUE KEY (id_crucero, id_ruta)
) ENGINE=InnoDB;

INSERT INTO CRUCEROS_RUTAS(id_crucero, id_ruta, salida, llegada) VALUES
(100, 1, "2022-12-23", "2022-12-30"),
(101, 2, "2023-1-22", "2023-2-1"),
(100, 5, "2023-1-19", "2023-2-2"),
(101, 7, "2023-2-4", "2023-3-6"),
(103, 3, "2022-12-20", "2023-1-15"),
(101, 4, "2023-3-10", "2023-4-18"),
(102, 6, "2023-2-4", "2023-3-2"),
(103, 7, "2023-1-18", "2023-3-2"),
(102, 8, "2022-12-28", "2023-2-1"),
(100, 9, "2022-12-31", "2023-1-14"),
(104, 9, "2023-1-17", "2023-2-4"),
(101, 10, "2023-5-17", "2023-6-28");

CREATE TABLE IF NOT EXISTS RESERVAS ( 
     id_reserva INT(9) NOT NULL AUTO_INCREMENT, 
     fecha DATE NOT NULL,
     precio FLOAT(4) NOT NULL,
     id_camarote_crucero INT(4) NOT NULL,
     PRIMARY KEY(id_reserva), 
     id_usuario INT(9) NOT NULL,
     id_ruta INT(5) NOT NULL
) ENGINE=InnoDB;

INSERT INTO RESERVAS (fecha, precio, id_camarote_crucero, id_usuario, id_ruta) VALUES
("2023-1-7", 70, 3, 1, 3),
("2023-1-8", 88, 4, 1, 6),
("2023-1-12", 198, 1, 1, 9);

CREATE TABLE IF NOT EXISTS USUARIOS ( 
	 id_usuario INT(9) NOT NULL AUTO_INCREMENT,
     correo VARCHAR(255) NOT NULL UNIQUE, 
     clave VARCHAR(255) NOT NULL, 
     nombre VARCHAR(255) NOT NULL, 
     apellidos VARCHAR(255) NOT NULL, 
     fecha_nacimiento DATE NOT NULL, 
     direccion VARCHAR(255) NOT NULL, 
     telefono INT(9) NOT NULL, 
     puntos INT(8) NULL,
	 imagen VARCHAR(255) NOT NULL,
     PRIMARY KEY(id_usuario),
     id_rol INT(1) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ROLES ( 
	 id_rol INT(1) NOT NULL AUTO_INCREMENT,
     tipo VARCHAR(255) NOT NULL,
     PRIMARY KEY(id_rol)
) ENGINE=InnoDB;

INSERT INTO ROLES (tipo) VALUES ("Administrador"), ("Registrado");
INSERT INTO USUARIOS (correo, clave, nombre, apellidos, fecha_nacimiento, direccion, telefono, puntos, imagen, id_rol) VALUES
("raulgomez@gmail.com", "$2y$10$kiFLlkFHGkStfArDpdVW1.sBwZ8b02HhMO6r1EfMUy..sO1ZQo.ca", "Raúl", "Gómez", "2003-10-5", "Calle Palencia, 21 1ºD, Vigo, Pontevedra, España", 666666666, 0, "Ayaka dandose cuenta de que ganó a Ayato.png", 1);

CREATE TABLE IF NOT EXISTS ACCIONES (
	id_acceso INT(7) NOT NULL AUTO_INCREMENT,
    fecha DATETIME NOT NULL,
    tipo VARCHAR(40) NOT NULL,
    PRIMARY KEY (id_acceso),
    id_usuario INT(9) NOT NULL
) ENGINE=InnoDB;

ALTER TABLE RESERVAS 
	ADD CONSTRAINT FK_ASS_1 FOREIGN KEY (id_camarote_crucero) REFERENCES CAMAROTES_CRUCEROS (id_camarote_crucero) ON DELETE RESTRICT,
    ADD CONSTRAINT FK_ASS_2 FOREIGN KEY (id_usuario) REFERENCES USUARIOS (id_usuario) ON DELETE RESTRICT,
    ADD CONSTRAINT FK_ASS_10 FOREIGN KEY (id_ruta) REFERENCES RUTAS (id_ruta) ON DELETE RESTRICT;

ALTER TABLE CAMAROTES_CRUCEROS 
    ADD CONSTRAINT FK_ASS_3 FOREIGN KEY (id_camarote) REFERENCES CAMAROTES (id_camarote) ON DELETE RESTRICT,
    ADD CONSTRAINT FK_ASS_4 FOREIGN KEY (id_crucero) REFERENCES CRUCEROS (id_crucero) ON DELETE RESTRICT;

ALTER TABLE CRUCEROS_RUTAS 
    ADD CONSTRAINT FK_ASS_5 FOREIGN KEY (id_crucero) REFERENCES CRUCEROS (id_crucero) ON DELETE RESTRICT,
    ADD CONSTRAINT FK_ASS_6 FOREIGN KEY (id_ruta) REFERENCES RUTAS (id_ruta) ON DELETE RESTRICT;

ALTER TABLE ACCIONES 
	ADD CONSTRAINT FK_ASS_7 FOREIGN KEY (id_usuario) REFERENCES USUARIOS (id_usuario) ON DELETE RESTRICT;
    
ALTER TABLE RUTAS 
	ADD CONSTRAINT FK_ASS_8 FOREIGN KEY (id_zona) REFERENCES ZONAS (id_zona) ON DELETE RESTRICT;
    
ALTER TABLE USUARIOS 
	ADD CONSTRAINT FK_ASS_9 FOREIGN KEY (id_rol) REFERENCES ROLES (id_rol) ON DELETE RESTRICT;