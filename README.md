<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Dashboard de registro de usuarios y roles

Es una Aplicación web para realizar registro de usuarios, roles y control de los mismo con Laravel 8. Puede crear, modificar, eliminar, ver los diferentes registros que estén en la plataforma. Es un SPA en la que todo se ve en una sola página.

### Herramientas que se utilizaron en su respectivo orden, así:

- [Laravel 8](https://laravel.com/docs/8.x "Laravel 8")
- Laravel UI Stisla 
- Laravel permission - Spatie
- Laravel Collective
- Base de datos MySQL (administracion.sql)
Este archivo se encuentra en la carpeta en `ctrlUsuarios\database\administracion.sql`

#### ¿Cómo Descargar el Dashboard?

- En el botón que se encuentra en la parte superior derecha del proyecto que dice `<>code` tendrá las opciones para clonar el repositorio o descargar los archivos del proyecto en formato `.zip`

- Una vez tenga los archivos en su equipo los podrá llevar al servidor local de su preferencia como es *Xampp, Wampserver*

- Cuando ya tenga la ubicación deberá ir a la carpeta del proyecto para ubicar la base de datos que esta en `ctrlUsuarios\database\administracion.sql`.
- Cree en MySQL una BD llamada administración, una vez la tenga vaya a la opción de `importar` dentro de esta base de datos seleccione la opción `examinar` ahí tendrá que elegir la ubicación del archivo `.sql` que anteriormente nombre.

- Ya teniendo esto configurado desde CMD o desde la terminal de Visual Studio Code ingresa: `php artisan serve` Esto va a tardar un tiempo mientras que carga todo (Solo es la primera vez); ya terminado este procedimiento le dará `Ctrl + clic del mouse` a la dirección que aparece de la url local que es: [http://127.0.0.1:8000](http://localhost "http://127.0.0.1:8000") y listo.

#### ¿Cómo ingreso al proyecto?
El acceso a la plataforma se puede dar con el usuario, Súper-administrador es:
> email: admin@hotmail.com
> password: 12345678

------------

#### Contenido
- CRUD
- Creación de usuario, roles y permisos
- Control de usuario
- Creación de autenticación

> Nota: Espero que con esto sea de su agrado para que pueda identificar como funciona y que puede implementarlo para otros proyectos personales o para empresa.
