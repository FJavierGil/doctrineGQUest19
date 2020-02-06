TDW: Doctrine Gestión Cuestionarios
======================================

[![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](http://opensource.org/licenses/MIT)
[![Minimum PHP Version](https://img.shields.io/badge/php-%5E7.4-blue.svg)](http://php.net/)

> Ejemplo ORM Doctrine

Para hacer más sencilla la gestión de los datos se ha utilizado
el ORM [Doctrine][doctrine]. Doctrine 2 es un Object-Relational Mapper que proporciona
persistencia transparente para objetos PHP. Utiliza el patrón [Data Mapper][dataMapper]
con el objetivo de obtener un desacoplamiento completo entre la lógica de negocio y la
persistencia de los datos en un SGBD.

## Instalación de la aplicación

Para realizar la instalación de la aplicación se debe crear una copia del fichero `./.env` y renombrarla
a `./.env.local`. A continuación se debe editar dicho fichero para asignar los parámetros:

* Configuración del servidor de bases de datos
* Nombre de la base de datos
* Configuración del acceso a la base de datos (usuario y contraseña)

Una vez editado el anterior fichero desde el directorio raíz del proyecto se deben ejecutar los comandos:
```
$ composer install
$ bin\doctrine orm:schema:update --dump-sql --force
```

Para comprobar la validez de la información de mapeo y la sincronización con la base de datos:
```
$ bin\doctrine orm:validate
```

##Estructura del proyecto:

A continuación se describe el contenido y estructura del proyecto:

* Directorio raíz del proyecto `.`:
    - `cli-config.php`: infraestructura de la interfaz de comandos del ORM Doctrine
    - `phpunit.xml` configuración de la suite de pruebas
* Directorio `bin`:
    - Ejecutables (*doctrine* y *phpunit*)
* Directorio `src`:
    - Subdirectorio `src/Entity`: entidades PHP (incluyen anotaciones de mapeo del ORM)
    - Subdirectorio `src/scripts`: algunos scripts de ejemplo
* Directorio `vendor`:
    - Componentes desarrollados por terceros (Doctrine, Dotenv, etc.)
* Directorio `tests`:
    - Conjunto de scripts para la ejecución de test con PHPUnit.

## Ejecución de pruebas

La aplicación incorpora un conjunto de herramientas para la ejecución de pruebas 
unitarias con [PHPUnit][phpunit]. Empleando este conjunto de herramientas es posible
comprobar de manera automática el correcto funcionamiento de los métodos de las entidades
sin la necesidad de herramientas adicionales.

Para configurar el entorno de pruebas se debe crear una copia del fichero `./phpunit.xml.dist`
y renombrarla como `./phpunit.xml`. A continuación se debe editar dicho fichero y modificar los
mismos parámetros que en la fase de instalación con los valores apropiados. Para lanzar la suite de pruebas se debe ejecutar:
```
$ ./bin/phpunit [--testdox] [--coverage-text] [-v]
```

[dataMapper]: http://martinfowler.com/eaaCatalog/dataMapper.html
[doctrine]: http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/
[phpunit]: http://phpunit.de/manual/current/en/index.html
