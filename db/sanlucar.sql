------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios_id CASCADE;

CREATE TABLE usuarios_id
(
    id bigserial PRIMARY KEY
);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id         bigint       PRIMARY KEY REFERENCES usuarios_id (id)
  , email      varchar(255) NOT NULL UNIQUE
  , password   varchar(255) NOT NULL
  , nombre     varchar(255) NOT NULL
  , apellido   varchar(255) NOT NULL
  , biografia  varchar(255)
  , url_avatar varchar(255)
  , auth_key   varchar(255)
  , token_val  varchar(255) UNIQUE
  , token_pass varchar(255) UNIQUE
  , coche_fav  bigserial    REFERENCES coches (id)
  , created_at timestamp(0) NOT NULL DEFAULT localtimestamp
  , updated_at timestamp(0)
);

DROP TABLE IF EXISTS trayectos CASCADE;

CREATE TABLE trayectos
(
    id           bigserial    PRIMARY KEY
  , origen       varchar(255) NOT NULL
  , destino      varchar(255) NOT NULL
  , conductor_id bigint       NOT NULL REFERENCES usuarios_id (id)
  , fecha        timestamp(0) NOT NULL
  , plazas       numeric(1)   NOT NULL
  , created_at   timestamp(0) NOT NULL DEFAULT localtimestamp
  , updated_at   timestamp(0)
);

DROP TABLE IF EXISTS coches CASCADE;

CREATE TABLE coches
(
    id         bigserial    PRIMARY KEY
  , marca      varchar(255) NOT NULL
  , modelo     varchar(255) NOT NULL
  , matricula  varchar(8)   NOT NULL
  , usuario_id bigint       NOT NULL REFERENCES usuarios_id (id)
  , plazas     numeric(1)   NOT NULL
  , created_at timestamp(0) NOT NULL DEFAULT localtimestamp
  , updated_at timestamp(0)
);

DROP TABLE IF EXISTS preferencias CASCADE;

CREATE TABLE preferencias
(
    id          bigserial    PRIMARY KEY
  , musica      boolean      NOT NULL
  , mascotas    boolean      NOT NULL
  , ninos       boolean      NOT NULL
  , fumar       boolean      NOT NULL
  , trayecto_id bigint       NOT NULL REFERENCES trayectos (id)
  , created_at  timestamp(0) NOT NULL DEFAULT localtimestamp
  , updated_at  timestamp(0)
);

DROP TABLE IF EXISTS pasajeros CASCADE;

CREATE TABLE pasajeros
(
    id          bigserial PRIMARY KEY
  , usuario_id  bigint    NOT NULL REFERENCES usuarios_id (id)
  , trayecto_id bigint    NOT NULL REFERENCES trayectos (id)
);

DROP TABLE IF EXISTS solicitudes CASCADE;

CREATE TABLE solicitudes
(
    id          bigserial PRIMARY KEY
  , usuario_id  bigint    NOT NULL REFERENCES usuarios_id (id)
  , trayecto_id bigint    NOT NULL REFERENCES trayectos (id)
  , aceptada    boolean   DEFAULT false
);

DROP TABLE IF EXISTS mensajes CASCADE;

CREATE TABLE mensajes
(
    id              bigserial    PRIMARY KEY
  , usuario_id      bigint       NOT NULL REFERENCES usuarios_id (id)
                                 ON DELETE NO ACTION ON UPDATE CASCADE
  , conversacion_id bigint       NOT NULL REFERENCES conversaciones (id)
                                 ON DELETE NO ACTION ON UPDATE CASCADE
  , mensaje         varchar(255) NOT NULL
  , created_at      timestamp(0) NOT NULL DEFAULT localtimestamp
);

DROP TABLE IF EXISTS conversaciones CASCADE;

CREATE TABLE conversaciones
(
    id          bigserial PRIMARY KEY
  , usuario1_id bigint    NOT NULL REFERENCES usuarios_id (id)
                          ON DELETE NO ACTION ON UPDATE CASCADE
  , usuario2_id bigint    NOT NULL REFERENCES usuarios_id (id)
                          ON DELETE NO ACTION ON UPDATE CASCADE
);

DROP TABLE IF EXISTS valoraciones CASCADE;

CREATE TABLE valoraciones
(
    id          bigserial    PRIMARY KEY
  , valorador_id bigint      NOT NULL REFERENCES usuarios_id (id)
                             ON DELETE NO ACTION ON UPDATE CASCADE
  , valorado_id bigint       NOT NULL REFERENCES usuarios_id (id)
                             ON DELETE NO ACTION ON UPDATE CASCADE
  , texto       varchar(255) NOT NULL
  , estrellas   numeric(1)   NOT NULL
  , created_at  timestamp(0) NOT NULL DEFAULT localtimestamp
);

INSERT INTO usuarios_id (id) VALUES (DEFAULT), (DEFAULT), (DEFAULT), (DEFAULT);

INSERT INTO usuarios (id, email, password, nombre, apellido, biografia, url_avatar, coche_fav)
    VALUES (1, 'rafa@rafa.com', crypt('rafa123', gen_salt('bf', 13)), 'Rafael', 'Bernal',
                'Me encanta conducir por Sanlúcar.',
                'https://www.dropbox.com/s/v6070v3zdo3m93b/rafa.jpg?dl=1', 1)
         , (2, 'pepe@pepe.com', crypt('pepe123', gen_salt('bf', 13)), 'Pepe', 'Romero',
                'Me gusta escuchar música mientras conduzco.',
                'https://www.dropbox.com/s/xklx7c5mnpt2kd0/pepe.jpg?dl=1', 2)
         , (3, 'manolo@manolo.com', crypt('manolo123', gen_salt('bf', 13)), 'Manuel', 'Pérez',
               'Me encanta la feria.',
               'https://www.dropbox.com/s/qva1onfjw87szmo/manuel.jpg?dl=1', 3)
         , (4, 'david@david.com', crypt('david123', gen_salt('bf', 13)), 'David', 'Ruiz',
               'Me gusta mucho viajar.',
               'https://www.dropbox.com/s/v504eg93v0dpjqd/david.jpg?dl=1', 3);

INSERT INTO trayectos (origen, destino, conductor_id, fecha, plazas)
    VALUES ('Calle San Nicolás, Sanlúcar de Barrameda, España', 'Calle Ancha, Sanlúcar de Barrameda, España', 1, localtimestamp + 'P1D'::interval, 2)
         , ('Calle Barrameda, Sanlúcar de Barrameda, España', 'Calle Ganado, Sanlúcar de Barrameda, España', 2, localtimestamp + 'P2D'::interval, 3);

INSERT INTO pasajeros (usuario_id, trayecto_id)
    VALUES (2, 1), (3, 1);

INSERT INTO coches (marca, modelo, matricula, usuario_id, plazas)
    VALUES ('Opel', 'Corsa', '1234 ABC', 1, 5)
         , ('Nissan', 'Micra', '4321 CBA', 2, 7)
         , ('Fiat', 'Punto', '9876 EFG', 3, 5);

INSERT INTO preferencias (musica, mascotas, ninos, fumar, trayecto_id)
    VALUES (true, true, true, false, 1)
         , (true, false, true, false, 2);

INSERT INTO mensajes (usuario_id, conversacion_id, mensaje)
    VALUES (1, 1, 'Hola Pepe. ¿Qué tal?')
         , (2, 1, 'Hola Rafa. Estoy muy bien.')
         , (2, 2, 'Hola Manolo. ¿Mañana conduces?');

INSERT INTO conversaciones (usuario1_id, usuario2_id)
    VALUES (1, 2), (2, 3);

INSERT INTO valoraciones (valorador_id, valorado_id, texto, estrellas)
    VALUES (1, 2, 'Viaje muy ameno y conducción perfecta.', 5)
         , (2, 3, 'No me ha gustado el viaje, pone la música demasiado alta.', 2);
