# StudentChoice

Este repositorio contiene el código fuente de un sistema de votación estudiantil con Laravel y Jetstream. Proporciona una plataforma segura y fácil de usar para elecciones estudiantiles. Utiliza Laravel, Jetstream, Livewire y Tailwind CSS. Características: autenticación de usuarios, gestión de candidatos, votación segura y una interfaz intuitiva.

## StudentChoice

Este repositorio contiene el código fuente para un sistema de votación estudiantil desarrollado con Laravel y Jetstream. El objetivo de este proyecto es proporcionar una plataforma segura y fácil de usar para la gestión de elecciones estudiantiles.

### Tecnologías Utilizadas

-   **Laravel**: Un framework de PHP para el desarrollo de aplicaciones web.
-   **Jetstream**: Un kit de inicio para Laravel que incluye autenticación y administración de sesiones.
-   **Livewire**: Un framework de front-end que permite crear interfaces dinámicas usando Laravel.
-   **Tailwind CSS**: Un framework de CSS para diseñar interfaces de usuario modernas y responsivas.

### Características

-   **Autenticación de Usuarios**: Registro, inicio de sesión y gestión de perfiles de usuario.
-   **Gestión de Candidatos**: Creación, edición y visualización de candidatos.
-   **Sistema de Votación**: Registro y conteo de votos de manera segura.
-   **Interfaz de Usuario Intuitiva**: Diseñada con Tailwind CSS para una experiencia de usuario fluida y moderna.

### Instalación

Para clonar y ejecutar este proyecto en tu máquina local, sigue estos pasos:

1. Clona el repositorio:

    ```bash
    git clone https://github.com/tu-usuario/student_voting_system.git
    cd StudentChoice
    ```

2. Instala las dependencias de PHP con Composer:

    ```bash
    composer install
    ```

3. Instala las dependencias de JavaScript con NPM:

    ```bash
    npm install
    ```

4. Configura tu archivo de entorno:

    ```bash
    cp .env.example .env
    ```

    Luego, configura tu base de datos y otros detalles en el archivo `.env`.

5. Ejecuta las migraciones para crear las tablas de la base de datos:

    ```bash
    php artisan migrate
    ```

6. Compila los activos front-end:

    ```bash
    npm run dev
    ```

7. Inicia el servidor de desarrollo:
    ```bash
    php artisan serve
    ```

### Contribución

Si deseas contribuir a este proyecto, por favor sigue los siguientes pasos:

1. Haz un fork del repositorio.
2. Crea una nueva rama (`git checkout -b feature/nueva-caracteristica`).
3. Realiza tus cambios y haz commits (`git commit -m 'Añadir nueva característica'`).
4. Envía tus cambios (`git push origin feature/nueva-caracteristica`).
5. Abre un Pull Request.

### Licencia

Este proyecto está licenciado bajo la [MIT License](LICENSE).
