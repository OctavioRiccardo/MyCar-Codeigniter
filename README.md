# 🚗 MyCar - Sistema de Alquiler de Vehículos

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.2-777bb4?style=for-the-badge&logo=php)](https://www.php.net/)
[![CodeIgniter 4](https://img.shields.io/badge/CodeIgniter-v4.x-ef4223?style=for-the-badge&logo=codeigniter)](https://codeigniter.com/)
[![Database](https://img.shields.io/badge/Database-MySQL-4479a1?style=for-the-badge&logo=mysql)](https://www.mysql.com/)
[![Frontend Framework](https://img.shields.io/badge/Bulma-CSS%201.0.2-00d1b2?style=for-the-badge&logo=bulma)](https://bulma.io/)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](https://opensource.org/licenses/MIT)

**MyCar** es una aplicación web moderna y robusta para la gestión y reserva de vehículos de alquiler (Autos, Motos y Camionetas), construida bajo el patrón arquitectónico **MVC (Modelo-Vista-Controlador)** utilizando el framework PHP **CodeIgniter 4** y estilizada de forma elegante con **Bulma CSS** y **FontAwesome**.

---

## 🌟 Características Principales

El sistema está dividido en dos roles principales bien delimitados mediante sesiones seguras:

### 👤 Área Pública y Clientes (`rol: cliente`)
- **Catálogo Interactivo**: Exploración de vehículos disponibles filtrados por tipo (Auto, Moto, Camioneta) con su respectiva información técnica y precio por día.
- **Registro y Autenticación**: Sistema seguro de registro de usuarios y login de clientes.
- **Gestión de Reservas**: 
  - Selección de vehículo y parametrización de fechas (fecha desde, cantidad de días).
  - Cálculo automático y dinámico del costo de alquiler y fecha hasta en la vista de resumen de reserva.
  - Selección de método de pago (Efectivo, Tarjeta, Transferencia).
- **Historial Personal**: Sección "Mis Alquileres" con el listado detallado de reservas realizadas y sus estados correspondientes.
- **Perfil de Usuario**: Visualización y edición de la información personal de contacto del cliente.

### 🔑 Área de Administración (`rol: administrador`)
- **Dashboard de Control**: Panel de mandos centralizado para administrar todos los módulos.
- **Gestión de Clientes (CRUD)**: Listado, edición y eliminación de usuarios registrados en el sistema (utilizando baja lógica / *Soft Deletes*).
- **Gestión de Vehículos (CRUD)**: Alta, baja, modificación y carga de imágenes de vehículos (utilizando baja lógica / *Soft Deletes*).
- **Gestión de Alquileres y Reservas**:
  - Control de solicitudes de reserva (Aprobar o Rechazar).
  - Control de entregas y devoluciones de vehículos (cambio automático de disponibilidad del vehículo y estado del alquiler).
  - Listado de alquileres activos.
- **Consultas Cruzadas Avanzadas**:
  - Historial detallado de clientes que han alquilado un vehículo específico.
  - Historial de vehículos alquilados por un cliente en particular.

---

## 🛠️ Tecnologías y Requerimientos

- **Servidor Web**: Apache / Nginx (recomendado WampServer, Laragon o XAMPP).
- **Lenguaje**: PHP 8.2 o superior.
- **Framework**: CodeIgniter v4.x.
- **Base de Datos**: MySQL / MariaDB.
- **Frontend**: Bulma CSS Framework 1.0.2 + FontAwesome Icons + CSS Personalizado.
- **Extensiones de PHP requeridas**:
  - `intl` (habilitada por defecto en servidores modernos).
  - `mbstring` (habilitada por defecto).
  - `mysqli` o `pdo_mysql` (para la conexión a base de datos).
  - `json` (habilitada por defecto).

---

## 🚀 Instalación y Configuración Paso a Paso

Sigue estos sencillos pasos para poner en marcha el proyecto en tu entorno local:

### 1. Clonar el Repositorio
Clona este repositorio en tu directorio raíz del servidor web (por ejemplo, `c:/wamp64/www/` para WampServer):
```bash
git clone https://github.com/tu-usuario/MyCar-Codeigniter.git
```

### 2. Instalar Dependencias de Composer
Accede a la carpeta del proyecto y ejecuta el siguiente comando para descargar las librerías necesarias:
```bash
composer install
```

### 3. Configurar las Variables de Entorno (`.env`)
El proyecto contiene un archivo `.env` configurado para el desarrollo local. Si no existe, realiza una copia del archivo `env` original y renómbralo como `.env`:
```bash
cp env_original .env
```
Abre el archivo `.env` y asegúrate de que las credenciales de tu base de datos y la URL base correspondan a tu entorno. Por ejemplo:
```ini
CI_ENVIRONMENT = development

# URL Base (Ajustar según tu puerto y carpeta)
app.baseURL = 'http://localhost:8080/'

# Configuración de Base de Datos
database.default.hostname = localhost
database.default.database = gestion-mycar
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 4. Crear e Importar la Base de Datos
1. Crea una base de datos en MySQL llamada `gestion-mycar`.
2. Importa el archivo SQL de la base de datos ubicado en la carpeta del proyecto:
   [app/Database/gestion-mycar.sql](file:///c:/wamp64/www/MyCar-Codeigniter/app/Database/gestion-mycar.sql)

### 5. Crear el Primer Administrador
La base de datos se entrega con datos de ejemplo para vehículos, pero no incluye usuarios por defecto para asegurar la confidencialidad. Para crear la primera cuenta con rol de **Administrador**, ejecuta la siguiente sentencia SQL en tu gestor de base de datos (phpMyAdmin, DBeaver, MySQL Workbench, etc.):

```sql
-- Usuario: admin | Contraseña: admin123
INSERT INTO `usuarios` (`nombre_usuario`, `password`, `rol`, `apellido_usuario`, `direccion`, `telefono`, `fecha_alta`, `deleted_at`) 
VALUES (
  'admin', 
  '$2y$12$hJtY.yu3MuONSJUrFf/y1ePCYezUTmuN7is0kPyFa7t3fRWlTsFsi', 
  'administrador', 
  'Administrador', 
  'Oficina Principal', 
  '123456789', 
  CURRENT_DATE(), 
  NULL
);
```

### 6. Ejecutar la Aplicación
Puedes arrancar la aplicación de dos formas:

- **Usando el Servidor de CodeIgniter (Recomendado)**:
  Ejecuta en tu terminal el siguiente comando en la raíz del proyecto:
  ```bash
  php spark serve
  ```
  Luego, abre en tu navegador: [http://localhost:8080](http://localhost:8080)

- **Usando tu Servidor Local (WampServer/XAMPP)**:
  Asegúrate de apuntar el VirtualHost de tu servidor web al directorio `/public` de la aplicación (no a la raíz) por razones de seguridad.

---

## 🔑 Credenciales de Prueba

- **Administrador**:
  - **Usuario**: `admin`
  - **Contraseña**: `admin123`
- **Cliente**:
  - Puedes registrarte directamente desde la interfaz pública haciendo clic en **Registrarse** en el menú de navegación superior.

---

## 📂 Estructura de Carpetas del Proyecto

Las partes más importantes del desarrollo se encuentran estructuradas de la siguiente manera:

```text
MyCar-Codeigniter/
│
├── app/                        # Directorio principal del backend
│   ├── Config/                 # Configuraciones globales (Rutas, Base de Datos, App)
│   ├── Controllers/            # Controladores de la aplicación (Lógica de flujo)
│   │   ├── AdministradorController.php # Control de vistas y operaciones del Admin
│   │   ├── AlquileresController.php    # Manejo de reservas, estados y devoluciones
│   │   ├── ClientesController.php      # Lógica de alquileres y perfil del cliente
│   │   ├── LoginController.php         # Validación de login y cierre de sesión
│   │   ├── VehiculosController.php     # CRUD y visualización de vehículos
│   │   ├── TestDBController.php        # Controlador de diagnóstico de conexión DB
│   │   └── ...
│   │
│   ├── Database/               # Archivo SQL y esquemas de base de datos
│   │   └── gestion-mycar.sql
│   │
│   ├── Models/                 # Modelos de datos de la aplicación
│   │   ├── AlquileresModel.php # Modelo para la tabla alquileres
│   │   ├── UsuariosModel.php   # Modelo para la tabla usuarios (SoftDeletes)
│   │   └── VehiculosModel.php  # Modelo para la tabla vehiculos (SoftDeletes)
│   │
│   └── Views/                  # Vistas de la interfaz de usuario
│       ├── layout/             # Componentes globales de diseño (header.php, footer.php)
│       ├── Vistas_Administrador/ # Vistas exclusivas de gestión de administración
│       ├── Vistas_Cliente/     # Vistas exclusivas para el panel del cliente
│       ├── Vistas_Comunes/     # Vistas públicas (Home, Login, Registro)
│       └── test_db.php         # Vista para el resultado del test de conexión
│
├── public/                     # Directorio expuesto al servidor web
│   ├── assets/                 # Recursos estáticos (estilizados)
│   │   ├── css/style.css       # Estilos globales y específicos del sistema
│   │   └── img/                # Imágenes de vehículos y logotipos
│   ├── index.php               # Punto de entrada de la aplicación
│   └── htaccess                # Reglas de Apache y redireccionamientos
│
├── .env                        # Configuración del entorno local (Ignorado por git)
├── composer.json               # Dependencias del proyecto y de desarrollo
└── spark                       # Script CLI para comandos de CodeIgniter 4
```

---

## ⚙️ Diagnóstico de Conexión a Base de Datos
El proyecto incluye un script de diagnóstico para verificar que tu conexión a la base de datos funciona adecuadamente. Una vez levantado el servidor, accede a:
👉 [http://localhost:8080/testdb](http://localhost:8080/testdb)

Esta pantalla mostrará un mensaje indicando si se logró conectar de manera satisfactoria al gestor MySQL o el mensaje de error correspondiente si las credenciales fallan.

---

## 🔒 Seguridad Implementada
- **Protección de Rutas**: Los controladores de administración y cliente validan de manera proactiva que la sesión exista y que el rol coincida con los permisos requeridos. En caso contrario, se realiza una redirección segura.
- **Hash de Contraseñas**: Toda contraseña es encriptada utilizando el algoritmo seguro **Bcrypt** mediante las funciones nativas de PHP antes de ser almacenada en la base de datos.
- **Baja Lógica (Soft Deletes)**: Los clientes y vehículos eliminados no se borran definitivamente de la base de datos (evitando inconsistencias en el historial de alquileres), sino que se marcan como inactivos mediante la columna `deleted_at`.

---

## 📄 Licencia
Este proyecto se distribuye bajo la licencia **MIT**. Puedes consultar más detalles en el archivo [LICENSE](file:///c:/wamp64/www/MyCar-Codeigniter/LICENSE).
