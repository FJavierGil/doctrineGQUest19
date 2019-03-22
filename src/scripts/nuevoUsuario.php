<?php
/**
 * PHP version 7.2
 * src\scripts\nuevoUsuario.php
 */

use TDW\GCuest\Entity\Usuario;

require 'inicio.php';

try {
    $nombre = 'user-' . random_int(0, 100000);
    $entityManager = \TDW\GCuest\Utils::getEntityManager();
    $usuario = new Usuario($nombre, $nombre . '@example.com', $nombre, (bool) random_int(0, 1));
    $entityManager->persist($usuario);
    $entityManager->flush();
    echo sprintf('Creado usuario Id: %d, Nombre: %s' . PHP_EOL, $usuario->getId(), $usuario->getUsername());
} catch (\Exception $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}
