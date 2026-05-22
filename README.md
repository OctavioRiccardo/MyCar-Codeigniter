# 🚗 MyCar - Sistema de Alquiler de Vehículos

¡Bienvenido a **MyCar**, una aplicación web moderna y robusta para la gestión y alquiler de vehículos, desarrollada sobre el framework **CodeIgniter 4**! 

Este proyecto está diseñado para ofrecer una experiencia fluida tanto a los clientes que buscan rentar un automóvil como a los administradores que gestionan la flota y las reservas.

---

## 📋 Índice
1. [Características Principales](#-características-principales)
2. [Arquitectura y Tecnologías](#-arquitectura-y-tecnologías)
3. [Requisitos del Sistema](#-requisitos-del-sistema)
4. [Instalación y Configuración](#-instalación-y-configuración)
5. [Estructura de la Base de Datos](#-estructura-de-la-base-de-datos)
6. [Estructura del Proyecto](#-estructura-del-proyecto)
7. [Licencia](#-licencia)

---

## ✨ Características Principales

El sistema se divide en dos módulos principales: el **Portal del Cliente** y el **Panel de Administración**.

### 👤 Portal del Cliente
*   **Catálogo Interactivo:** Exploración de vehículos disponibles con filtros avanzados (marca, categoría, tipo de transmisión, combustible, precio).
*   **Reservas en Línea:** Proceso de reserva intuitivo seleccionando fechas de entrega y devolución con cálculo automático del costo total.
*   **Gestión de Perfil:** Registro de usuarios, inicio de sesión seguro y panel personal para ver el historial de reservas y el estado actual de cada una.
*   **Notificaciones por Correo:** Confirmaciones de reserva y actualizaciones de estado automáticas.

### 🔑 Panel de Administración (Backoffice)
*   **Dashboard Estadístico:** Vista general de ingresos mensuales, vehículos activos, reservas pendientes y estadísticas de uso de la flota.
*   **Gestión de Flota (CRUD):** Registro de nuevos vehículos con especificaciones detalladas, carga de imágenes y control de estado de disponibilidad (Disponible, Rentado, En Mantenimiento).
*   **Gestión de Categorías:** Clasificación de vehículos (Económico, SUV, Sedán, Deportivo, Eléctrico) con tarifas base personalizadas.
*   **Control de Reservas:** Aprobación, cancelación y finalización de reservas, además del registro de devoluciones.
*   **Gestión de Usuarios:** Registro de clientes y asignación de roles de administrador.

---

## 🛠️ Arquitectura y Tecnologías

El proyecto sigue el patrón de diseño **MVC (Modelo-Vista-Controlador)** provisto por CodeIgniter, garantizando un código limpio, modular y escalable.

*   **Backend:** PHP 8.1+ & CodeIgniter 4
*   **Base de Datos:** MySQL 8.0 / MariaDB
*   **Frontend:** HTML5, CSS3, JavaScript (Bootstrap 5 / Tailwind CSS para un diseño responsive y moderno)
*   **Manejador de Dependencias:** Composer

---

## 💻 Requisitos del Sistema

Antes de comenzar, asegúrate de cumplir con los siguientes requisitos:
*   PHP $\ge$ 8.1 (con las extensiones activadas: `intl`, `mbstring`, `curl`, `mysqlnd`, `gd`).
*   Servidor web (Apache con `mod_rewrite` habilitado, Nginx o el servidor de desarrollo integrado de CodeIgniter).
*   MySQL o MariaDB.
*   Composer instalado globalmente.

---

## 🚀 Instalación y Configuración

Sigue estos sencillos pasos para poner en marcha el proyecto localmente:

### 1. Clonar el repositorio
```bash
git clone https://github.com/OctavioRiccardo/MyCar-Codeigniter.git
cd MyCar-Codeigniter
```

### 2. Instalar dependencias con Composer
```bash
composer install
```

### 3. Configurar las variables de entorno
Copia el archivo de configuración de ejemplo `.env` y renómbralo:
```bash
cp env .env
```
Abre el archivo `.env` y configura los detalles de tu base de datos y la URL del sitio:
```env
# Configuración de Entorno
CI_ENVIRONMENT = development

# URL Base
app.baseURL = 'http://localhost:8080/'

# Configuración de Base de Datos
database.default.hostname = localhost
database.default.database = mycar_db
database.default.username = tu_usuario
database.default.password = tu_contraseña
database.default.DBDriver = MySQLi
database.default.DBPrefix = 
database.default.port = 3306
```

### 4. Ejecutar las Migraciones y Seeders
Crea las tablas necesarias en la base de datos y carga los datos de prueba (vehículos por defecto, categorías y usuario administrador):
```bash
php spark migrate
php spark db:seed MainSeeder
```
*(Nota: El administrador por defecto se creará con las credenciales indicadas en el archivo del Seeder, usualmente admin@mycar.com / admin123).*

### 5. Iniciar el Servidor de Desarrollo
Puedes utilizar el servidor interno de CodeIgniter para ejecutar la aplicación:
```bash
php spark serve
```
La aplicación estará disponible en [http://localhost:8080](http://localhost:8080).

---

## 🗃️ Estructura de la Base de Datos

El esquema relacional consta de las siguientes tablas principales:

| Tabla | Descripción |
| :--- | :--- |
| **`usuarios`** | Almacena la información de clientes y administradores (ID, nombre, correo, password hash, rol, fecha_registro). |
| **`categorias`** | Categorías de vehículos (ID, nombre, tarifa_diaria, descripcion). |
| **`vehiculos`** | Flota de autos (ID, categoria_id, marca, modelo, año, matricula, color, estado, imagen_url). |
| **`reservas`** | Registro de reservas (ID, usuario_id, vehiculo_id, fecha_inicio, fecha_fin, costo_total, estado). |
| **`pagos`** | Detalle de transacciones (ID, reserva_id, monto, metodo_pago, fecha_pago, estado). |

---

## 📂 Estructura del Proyecto

A continuación se muestra la estructura estándar simplificada del framework aplicada a MyCar:

```text
MyCar-Codeigniter/
├── app/
│   ├── Config/          # Configuración de la aplicación
│   ├── Controllers/     # Controladores (Admin, Cliente, Auth, etc.)
│   ├── Database/        # Migraciones y Seeders para la BD
│   ├── Models/          # Modelos de datos (VehiculoModel, ReservaModel, etc.)
│   ├── Views/           # Vistas (Plantillas HTML, Dashboard, Catálogo)
│   └── Filters/         # Filtros de seguridad (Autenticación y Roles)
├── public/              # Directorio público (index.php, CSS, JS, Imágenes)
├── writable/            # Directorio de escritura (Logs, Cargas de imágenes)
├── .env                 # Variables de entorno (no subir a producción)
├── composer.json        # Dependencias de PHP
└── README.md            # Documentación del proyecto
```

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Consúltase el archivo `LICENSE` para más detalles.
