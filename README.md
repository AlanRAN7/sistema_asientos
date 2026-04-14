# 📄 Sistema de Asientos

## Descripción

Este proyecto consiste en un sistema de gestión de asientos que permite:

- Visualizar asientos organizados por filas
- Seleccionar y deseleccionar asientos
- Manejar estados (**disponible / ocupado**)
- Liberar automáticamente asientos después de 5 minutos
- Mostrar alertas cuando un asiento está por liberarse

El sistema está desarrollado con:

- **Frontend:** HTML, CSS (Bootstrap), JavaScript  
- **Backend:** PHP  
- **Base de datos:** MySQL  

---

## Requisitos

- Tener instalado **XAMPP**
- Navegador web (Chrome, Brave, etc.)

---

## Pasos para ejecutar el proyecto

### 1. Instalar XAMPP

Descargar e instalar XAMPP desde:  
https://www.apachefriends.org/

---

### 2. Clonar el proyecto

Clonar o copiar el proyecto dentro de la carpeta:
`C:\xampp\htdocs\`

---

### 3. Crear la base de datos y tabla

1. Abrir **phpMyAdmin**
2. Crear una base de datos llamada:

```sql
CREATE TABLE asientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fila CHAR(1),
    numero INT,
    estado ENUM('disponible', 'ocupado') DEFAULT 'disponible',
    reservado_at DATETIME NULL
);
```

### 4. Generar los asientos
Abrir en el navegador la siguiente URL:
`http://localhost/sistema_asientos/backend/initSeats.php`

#### Funcionamiento del sistema:
Los asientos pueden seleccionarse con un clic
Cambian de estado visual:
🟢 Disponible
🔴 Ocupado
🟡 Por liberarse
Después de 5 minutos:
- El asiento se libera automáticamente
- Se muestra una alerta cuando faltan pocos segundos