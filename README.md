# Store API

Esta API facilita la simulación de registro y gestión de datos mediante consultas al ORM Eloquent. Además, integra un sólido sistema de autenticación y una pasarela de pago con Stripe, brindando una experiencia completa y segura para los usuarios.

## Requisitos

- PHP 8.2
- Composer
- Laravel 11
- OAuth2.0
- MySQL

## Instalación

1. Clona este repositorio:

   ```bash
   git clone https://github.com/vjlr20/store-api.git

2. Instala las dependecias:

    ```bash
    cd store_api
    composer install
    ```

3. Configura la base de datos:
    
    - Crea una base de datos MySQL y modifica el archivo .env de las variables de entorno.
        
    ```dosini
    # .env.example, committed to repo
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=test
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    - Carga la base de datos o genera las migraciones usando los comando de artisan

    ```bash
    php artisan migrate

4. Configura las credenciales para uso de OAuth 2.0 usando <strong>laravel\passport</strong>:

    ```bash
    php artisan passport:install
    ```

    En caso de fallar este comando, debes forzar la generación de llaves usando la variable <strong>--force</strong>.

    ```bash
    php artisan passport:install --force
    ```

5. Ejecuta el servidor de artisan:

    ```bash
    php artisan serve
    ```
