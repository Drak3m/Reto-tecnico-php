from fpdf import FPDF

# Crear PDF

# Fuente

# Contenido
contenido
Proyecto de Consumo de Servicios SOAP y REST

Este proyecto demuestra cómo consumir servicios SOAP y REST utilizando PHP. Incluye ejemplos funcionales, una estructura modular y una colección de pruebas para Postman.

----------------------------------------
Requisitos

- PHP 7.4 o superior
- Acceso a internet
- Extensiones habilitadas:
  - soap
  - curl

Puedes habilitarlas en tu archivo php.ini.

----------------------------------------
Instalación y Ejecución

1. Clona el repositorio:
   git clone https://github.com/Drak3m/Reto-tecnico-php
   cd proyecto-servicios

2. Configura los tokens y endpoints
   Abre los archivos en services/ y modifica:
   - Tokens de autenticación
   - Endpoints de los servicios
   - Archivos WSDL, según la documentación del servicio

3. Ejecuta un servidor local:
   php -S localhost:8000

4. Abre en el navegador:
   http://localhost:8000/index.php

----------------------------------------
Estructura del Proyecto

index.php       => Landing principal / punto de entrada
services/       => Lógica de integración para servicios SOAP y REST
assets/         => Archivos estáticos (estilos CSS)
postman/        => Colección de pruebas (formato .json)

----------------------------------------
Pruebas con Postman

Dentro de la carpeta postman/ encontrarás una colección de pruebas para validar las funcionalidades SOAP y REST.

1. Abre Postman
2. Importa el archivo .json
3. Modifica variables si es necesario (token, URL base)
4. Ejecuta la colección

----------------------------------------
Notas Adicionales

- Se recomienda usar un entorno local como XAMPP, Laragon o Docker si prefieres una experiencia más completa.
- Este proyecto está pensado como un ejemplo educativo. Los datos sensibles deben mantenerse fuera del repositorio en entornos reales.

----------------------------------------
Contacto

Para soporte o dudas, puedes contactar a 
Yeferson Ladino 
"""
