# Proyecto Laravel 10 - Agendar Citas

Este proyecto es una aplicación de gestión de usuarios desarrollada en Laravel 10. Proporciona funcionalidades básicas como creación, edición, eliminación y visualización de usuarios.

## Requisitos del sistema

Asegúrate de tener instalados los siguientes requisitos para ejecutar este proyecto:

- **PHP**: >= 8.1
- **Composer**: >= 2.0
- **Node.js**: >= 16.0 y NPM
- **Base de datos**: MySQL o cualquier base de datos compatible con Laravel

## Instalación

Sigue estos pasos para configurar y ejecutar el proyecto localmente:

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/nombre-del-repositorio.git
cd nombre-del-repositorio
```

2. Instalar dependencias de PHP
Asegúrate de tener Composer instalado y ejecuta el siguiente comando para 

```bash
composer install
```

3. Instalar dependencias de NPM
Este proyecto utiliza algunos paquetes de front-end. Instálalos con el siguiente comando:

```bash
npm install
```

4. Configurar el archivo .env
Copia el archivo .env.example y renómbralo a .env:


```bash
cp .env.example .env
```
Luego, abre el archivo .env y configura los siguientes valores:

Nombre de la base de datos: Cambia DB_DATABASE al nombre de la base de datos que desees utilizar. Ejemplo:

```bash
DB_DATABASE=testlaravel
DB_USERNAME=root
DB_PASSWORD=
```
> [!NOTE]
> Asegúrate de haber creado la base de datos previamente en tu servidor MySQL.


5. Generar la clave de la aplicación
Genera una clave de aplicación única utilizando el siguiente comando:

```bash
php artisan key:generate
```
6. Ejecutar las migraciones
Ejecuta las migraciones para crear las tablas necesarias en tu base de datos:

```bash
php artisan migrate
```
7. Compilar los assets front-end
Compila los archivos CSS y JavaScript utilizando Laravel Mix o Vite:

```bash
npm run dev
```
Para la compilación en producción:
