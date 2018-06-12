# Instrucciones de instalación y despliegue

## En local

Para instalar la aplicación en local necesitamos los siguientes requisitos:

* PHP 7.1.0 o superior
* PostgreSQL
* [Composer](https://getcomposer.org/)

Una vez tengas los requisitos deberás realizar una serie de pasos para una correcta instalación de la aplicación:

1. Clonar el siguiente repositorio:

    ```
    ~ git clone https://github.com/rafabernal94/sanlucar.git
    ```

2. Desde la raíz del proyecto, instalar los paquetes de composer:

    ```
    ~ composer install
    ```

3. Desde la raíz del proyecto, crear la base de datos con sus respectivas tablas:

    ```
    ~ db/create.sh
    ```

    ```
    ~ db/load.sh
    ```

4. Crear un archivo con el nombre *env*  en la raíz del proyecto para introducir las siguientes variables de entorno:

    * SMTP_PASS: Clave generada con la contraseña de la aplicación.
    * DROPBOX_TOKEN: Clave secreta de Dropbox.
    * GOOGLEMAPS_KEY: Clave para hacer uso de Google Maps.

5. Desde la raíz del proyecto, iniciamos el servidor:

    ```
    ~ make serve
    ```

6. Una vez que se haya iniciado el servidor podrás acceder a la aplicación desde la siguiente URL:

    http://localhost:8080

## En la nube

Para instalar la aplicación en la nube necesitamos:

* [Heroku CLI](https://devcenter.heroku.com/articles/heroku-cli)

Para la instalación seguiremos los siguientes pasos:

1. Si no tienes cuenta en Heroku, puedes crearla desde el siguiente [enlace](https://id.heroku.com/login).

2. Iniciar sesión en Heroku y crear una nueva aplicación.

3. Crear las mismas variables de entorno que tienes en local, añadiendo una más: `YII_ENV=prod`.

4. Añadir a la aplicación el *add-on* Heroku Postgres.

5. Desde la línea de comando debes iniciar sesión en Heroku:

    ```
    ~ heroku login
    ```

6. Insertar las tablas en la base de datos de Heroku:

    ```
    ~ heroku psql < db/sanlucar.sql
    ```

7. Sincronizar el proyecto con GitHub, y seleccionar en que rama queremos realizar el despliegue.
