# 🕒 Asistencias - Sistema de Control de Asistencia de Empleados

**Asistencias** es una aplicación web desarrollada con Laravel que permite gestionar el control de asistencias de empleados en diferentes sucursales y departamentos. Incluye registro de entradas y salidas, generación de informes, gráficos, gestión de usuarios y exportación en PDF.

## 🚀 Características principales

- Registro de entrada y salida de empleados mediante DNI
- Gestión de usuarios, roles, sucursales y departamentos
- Filtros de asistencias por fecha y sucursal
- Informes descargables en formato PDF
- Gráficos dinámicos de asistencia diaria
- Interfaz administrativa con DataTables y SweetAlert
- Autenticación y control de acceso por roles

## 🛠️ Tecnologías utilizadas

- Laravel 12
- MySQL
- Blade (vistas)
- AdminLTE (plantilla)
- Morris.js (gráficos)
- SweetAlert2
- DataTables
- TCPDF (PDF)

---

## ⚙️ Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/Diego-Oruezabal/asistencias.git
   cd asistencias

2. Instala dependencias:
    ```bash
    composer install
    npm install && npm run dev

3. Crea una base de datos en MySQL y configura el archivo .env:
    ```bash
    DB_DATABASE=asistencias
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña

4. Ejecuta las migraciones y (opcionalmente) los seeders:
    ```bash
    php artisan migrate

5. Levanta el servidor:
    ```bash
    php artisan serve

6. Accede a la aplicación en: http://127.0.0.1:8000

## 📈 Módulos del sistema

Usuarios: Alta, edición, roles, eliminación, validación

Empleados: Registro y edición con vinculación a sucursal y departamento

Sucursales y Departamentos: CRUD completo

Asistencias: Registro de entrada/salida, listado, filtros, generación de informes

Informes PDF: Generados con TCPDF, personalizables por fecha y sucursal

Gráficos: Asistencias de los últimos 5 días (Morris.js)

## 💡 Mejoras futuras

Autenticación por QR o huella

Registro de geolocalización

Panel de métricas (KPI)

Exportación a Excel

App móvil vinculada

API REST para integración externa

## 🧑‍💻 Autor
Diego Oruezabal
📧 diegooruezabal@gmail.com
🌐 [elpatronsingleton.diegooru.com](http://elpatronsingleton.diegooru.com/)
⚙️ https://doom-portfolio.netlify.app/es
📂 https://github.com/Diego-Oruezabal
