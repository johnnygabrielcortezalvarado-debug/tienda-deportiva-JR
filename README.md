# 👟 SportStore — Tienda de Ropa Deportiva

Aplicación web dinámica desarrollada con **PHP + MySQL** bajo el patrón **MVC**.

**Autor:** Cortez Alvarado Johnny Gabriel  
**Asignatura:** Desarrollo de Aplicaciones Web — 2026A  
**Proyecto:** Segundo Parcial

---

## 📋 Descripción

Sistema CRUD para gestionar el catálogo de una tienda de ropa deportiva.  
Permite administrar **Categorías** y **Productos** con todas las operaciones básicas.

---

## 🗂️ Estructura del Proyecto

```
tienda_deportiva/
├── database/
│   └── tienda_deportiva.sql      ← Script SQL
├── config/
│   └── database.php              ← Conexión PDO
├── app/
│   ├── controllers/
│   │   ├── CategoriaController.php
│   │   └── ProductoController.php
│   ├── models/
│   │   ├── CategoriaModel.php
│   │   └── ProductoModel.php
│   └── views/
│       ├── layout/
│       │   ├── header.php
│       │   └── footer.php
│       ├── dashboard.php
│       ├── categorias/
│       │   ├── index.php
│       │   ├── crear.php
│       │   └── editar.php
│       └── productos/
│           ├── index.php
│           ├── crear.php
│           └── editar.php
└── public/
    ├── index.php                 ← Punto de entrada
    ├── css/
    │   └── estilos.css
    └── js/
        └── validaciones.js
```

---

## ⚙️ Requisitos

- XAMPP (PHP 8.0+ y MySQL 5.7+)
- Navegador web moderno

---

## 🚀 Instalación y Ejecución

### 1. Clonar o copiar el proyecto
Coloca la carpeta `tienda_deportiva/` dentro de:
```
C:/xampp/htdocs/tienda_deportiva/
```

### 2. Crear la base de datos
1. Abre **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Crea una base de datos llamada `tienda_deportiva`
3. Selecciónala y ve a la pestaña **SQL**
4. Copia y ejecuta el contenido de `database/tienda_deportiva.sql`

### 3. Configurar la conexión
Edita `config/database.php` si tus credenciales son distintas:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');          // tu contraseña de MySQL
define('DB_NAME', 'tienda_deportiva');
```

### 4. Ejecutar el proyecto
Abre en el navegador:
```
http://localhost/tienda_deportiva/public/index.php
```

---

## ✅ Funcionalidades

| Módulo      | Crear | Leer | Editar | Eliminar |
|-------------|:-----:|:----:|:------:|:--------:|
| Categorías  |  ✅   |  ✅  |   ✅   |    ✅    |
| Productos   |  ✅   |  ✅  |   ✅   |    ✅    |

- 🔍 Búsqueda de productos por nombre o categoría
- ✅ Validaciones en frontend (JavaScript) y backend (PHP)
- 📊 Dashboard con estadísticas del inventario
- 📱 Diseño responsivo para móvil y escritorio
- 🔒 Protección: no se pueden eliminar categorías con productos asociados

---

## 🗄️ Base de Datos

**Tabla `categorias`:** id, nombre, descripcion, estado, created_at  
**Tabla `productos`:** id, categoria_id (FK), nombre, descripcion, precio, stock, talla, imagen_url, estado, created_at

---

## 🧱 Patrón MVC

- **Modelo:** Acceso y consultas a MySQL vía PDO
- **Vista:** Interfaces HTML/CSS sin lógica de negocio
- **Controlador:** Recibe peticiones, valida datos y coordina modelo + vista
