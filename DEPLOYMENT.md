# Arsenal Tracker - Guía de Instalación Local para Producción

## 🚀 Requisitos Previos

### Software Necesario
- **Docker Desktop** (última versión)
- **Git** (para clonar el repositorio)
- **Navegador Web** moderno (Chrome, Firefox, Edge)

## 📋 Pasos de Instalación (Para Desarrollador/Administrador)

### 1. Clonar el Repositorio
```bash
# Clonar el proyecto
git clone 
```
[arsenal-tracker](https://github.com/ElBatou/arsenal-tracker/tree/master)
```bash
cd arsenal-tracker
```

### 2. Configurar Variables de Entorno
```bash
# Copiar archivo de configuración
cp .env.example .env

# Editar el archivo .env con tu configuración
nano .env
```

### 3. Generar Clave de Aplicación (optional)
```bash
# Generar clave de la aplicación
php artisan key:generate
```

### 4. Optimizar para Producción
```bash
# Optimizar la aplicación para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Empaquetar para Distribución
```bash
# Crear archivo ZIP para distribución
zip -r arsenal-tracker-production.zip . -x ".git/*" "node_modules/*" "vendor/*" ".env"
```

## 🌐 Acceso para Usuarios No Técnicos

### ⚠️ INSTRUCCIONES SIMPLES PARA USUARIO FINAL

#### **Solo 3 Pasos para Iniciar:**

1. **Instalar Docker Desktop**
   - Descargar desde: https://www.docker.com/products/docker-desktop/
   - Instalar y abrir Docker Desktop
   - Esperar a que esté completamente iniciado

2. **Descomprimir el Proyecto**
   - Descomprimir el archivo `arsenal-tracker-production.zip`
   - Abrir la carpeta `arsenal-tracker`
   - Crear `.env` con la configuración necesaria, puedes copiar el archivo `.env.production.example`

3. **Iniciar la Aplicación**
   - **Abrir terminal/símbolo del sistema**
   - **Navegar a la carpeta del proyecto**:
     ```bash
     cd ruta/a/arsenal-tracker
     ```
   - **Ejecutar UN SOLO COMANDO**:
     ```bash
     docker compose -f compose.prod.yaml up --build -d
     ```

4. **Esperar 2-3 minutos** y acceder a la aplicación

### 🌐 URLs de Acceso
- **Aplicación Principal**: http://localhost
- **Panel de Admin**: http://localhost/admin

### 🔐 Credenciales por Defecto
- **Usuario**: ferco_clpm@hotmail.com
- **Contraseña**: password

> ⚠️ **Importante**: Cambiar estas credenciales después del primer acceso

## 🎯 Funciones Principales Disponibles
- ✅ **Ver lista de armas**
- ✅ **Buscar armas por número de serie**
- ✅ **Ver detalles del arma**
- ✅ **Asignar armas a personal**
- ✅ **Generar códigos QR**
- ✅ **Ver historial de asignaciones**
- ✅ **Gestión completa en español**

## 🛠️ Comandos de Mantenimiento (Para Administradores)

### Verificar Estado
```bash
# Verificar que los contenedores estén corriendo
docker compose -f compose.prod.yaml ps

# Ver logs si hay problemas
docker compose -f compose.prod.yaml logs -f
```

### Detener la Aplicación
```bash
# Detener todos los contenedores
docker compose -f compose.prod.yaml down
```

### Reiniciar la Aplicación
```bash
# Reiniciar todos los contenedores
docker compose -f compose.prod.yaml restart
```

### Actualizar la Aplicación
```bash
# Obtener nueva versión y reconstruir
docker compose -f compose.prod.yaml up --build -d
```

## 📋 Resumen para Usuario Final

### ✅ Lo que Necesita Hacer
1. **Instalar Docker Desktop**
2. **Descomprimir el archivo ZIP recibido**
3. **Abrir terminal en la carpeta del proyecto**
4. **Ejecutar UN SOLO COMANDO**:
   ```bash
   docker compose -f compose.prod.yaml up --build -d
   ```
5. **Esperar 2-3 minutos**
6. **Abrir navegador y ir a**: http://localhost
7. **Listo para usar el sistema**

### 🎯 Características Disponibles
- 📋 **Gestión completa de armas**
- 👥 **Asignación de personal**
- 📱 **Códigos QR para identificación**
- 📊 **Historial completo de asignaciones**
- 🔍 **Búsqueda avanzada**
- 🌐 **Interfaz completamente en español**

## 🆘 Soporte Técnico

### Si Hay Problemas
1. **Verificar que Docker Desktop esté corriendo**
2. **Revisar que el puerto 80 esté libre**
3. **Limpiar caché del navegador**
4. **Reiniciar Docker si es necesario**
5. **Verificar que el archivo compose.prod.yaml exista**

### Verificar Instalación
```bash
# Verificar versión de Docker
docker --version
docker compose version

# Verificar contenedores activos
docker ps
```

### Contacto para Soporte
- 📧 **Email**: ferco_clpm@hotmail.com

---

## 📝 Notas Importantes

### 🔒 Seguridad
- **Cambiar contraseñas por defecto** inmediatamente
- **Mantener Docker Desktop actualizado**
- **Realizar backups periódicos**

### 💾 Respaldo de Datos
- **Los datos se guardan en volúmenes Docker**
- **Para respaldar**: Contactar administrador
- **Location**: Volúmenes Docker persistentes

### 🌟 Recomendaciones
- **Usar navegador Chrome o Firefox**
- **Mantener conexión estable**
- **No cerrar la terminal mientras se inicia**
- **Esperar tiempo de inicio** (2-3 minutos)

### 🐳 Ventajas de Esta Configuración
- **Configuración optimizada** para producción
- **Un solo comando** para iniciar
- **Persistencia de datos** automática
- **Seguridad mejorada** por defecto

---

## 🚀 Para Desarrolladores: Creación del Paquete de Producción

### Archivos Necesarios para Distribución:
1. **compose.prod.yaml** - Configuración Docker de producción
2. **Dockerfile.prod** - Imagen optimizada para producción
3. **nginx.conf** - Configuración Nginx
4. **.env.production** - Variables de entorno de producción
5. **Todo el código fuente** (excepto carpetas de desarrollo)

### Comandos de Empaquetado:
```bash
# Optimizar aplicación
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Crear paquete de distribución
zip -r arsenal-tracker-production.zip . -x ".git/*" "node_modules/*" "vendor/*" ".env" "compose.yaml" "Dockerfile"
```

---

**¡Sistema listo para producción local con un solo comando!** 🎉

### 🎯 Resumen Final para Usuario No Técnico:

1. **Instalar Docker Desktop**
2. **Descomprimir archivo ZIP**
3. **Abrir terminal en la carpeta**
4. **Ejecutar**: `docker compose -f compose.prod.yaml up --build -d`
5. **Esperar 2-3 minutos**
6. **Ir a**: http://localhost
7. **¡Listo!**