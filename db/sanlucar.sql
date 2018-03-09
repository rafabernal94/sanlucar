------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id         bigserial    PRIMARY KEY
  , email      varchar(255) NOT NULL UNIQUE
  , password   varchar(255) NOT NULL
  , nombre     varchar(255) NOT NULL
  , apellido   varchar(255) NOT NULL
  , biografia  varchar(255)
  , auth_key   varchar(255)
  , token_val  varchar(255) UNIQUE
  , created_at timestamp(0) NOT NULL DEFAULT localtimestamp
  , updated_at timestamp(0)
);

INSERT INTO usuarios (email, password, nombre, apellido, biografia)
    VALUES ('rafa@rafa.com', crypt('rafa123', gen_salt('bf', 13)), 'Rafael', 'Bernal',
                'Me encanta conducir por Sanlúcar.'),
            ('pepe@pepe.com', crypt('pepe123', gen_salt('bf', 13)), 'Pepe', 'Romero',
                'Me gusta escuchar música mientras conduzco.');
