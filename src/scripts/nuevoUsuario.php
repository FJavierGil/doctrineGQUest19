<?php
/**
 * PHP version 7.4
 * src\scripts\nuevoUsuario.php
 */

use TDW\GCuest\Entity\Usuario;
use TDW\GCuest\Utils;

require 'inicio.php';

try {
    $nombre = 'user-' . random_int(0, 100000);
    $entityManager = Utils::getEntityManager();
    $usuario = new Usuario($nombre, $nombre . '@example.com', $nombre, (bool) random_int(0, 1));
    $entityManager->persist($usuario);
    $entityManager->flush();
    echo sprintf('Creado usuario Id: %d, Nombre: %s' . PHP_EOL, $usuario->getId(), $usuario->getUsername());
} catch (Throwable $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}
