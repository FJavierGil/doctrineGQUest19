<?php
/**
 * PHP version 7.4
 * src\scripts\eliminaUsuario.php
 */

use TDW\GCuest\Entity\Usuario;
use TDW\GCuest\Utils;

require 'inicio.php';

if ($argc !== 2) {
    $texto = <<< ______MOSTRAR_USO
    *> Empleo: {$argv[0]} <idUsuario>
    Elimina el usuario indicado por <idUsuario>

______MOSTRAR_USO;
    die($texto);
}

try {
    $nombre = $argv[1];
    $entityManager = Utils::getEntityManager();
    $usuario = $entityManager
        ->find(Usuario::class, $nombre);
    if (null === $usuario) {
        die('Usuario [' . $nombre . '] no existe.' .PHP_EOL);
    }
    $entityManager->remove($usuario);
    $entityManager->flush();
} catch (Throwable $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}
