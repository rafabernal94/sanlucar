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

INSERT INTO usuarios_id (id) VALUES (DEFAULT), (DEFAULT);

INSERT INTO usuarios (id, email, password, nombre, apellido, biografia)
    VALUES (1, 'rafa@rafa.com', crypt('rafa123', gen_salt('bf', 13)), 'Rafael', 'Bernal',
                'Me encanta conducir por Sanlúcar.')
         , (2, 'pepe@pepe.com', crypt('pepe123', gen_salt('bf', 13)), 'Pepe', 'Romero',
                'Me gusta escuchar música mientras conduzco.');

INSERT INTO trayectos (origen, destino, conductor_id, fecha, plazas)
    VALUES ('Calle San Nicolás', 'Calle Ancha', 1, localtimestamp + 'P1D'::interval, 4)
         , ('Calle Barrameda', 'Calle Ganado', 2, localtimestamp + 'P2D'::interval, 3);
