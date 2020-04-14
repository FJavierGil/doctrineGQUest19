<?php

/**
 * PHP version 7.4
 * src/scripts/listadoUsuarios.php
 */

require __DIR__ . '/inicio.php';

use TDW\GCuest\Entity\Usuario;
use TDW\GCuest\Utility\Utils;

try {
    $entityManager = Utils::getEntityManager();
    $usuarios = $entityManager->getRepository(Usuario::class)->findAll();
    $entityManager->close();
} catch (Throwable $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}

// Salida formato JSON
if (in_array('--json', $argv, false)) {
    echo json_encode(
        [ 'usuarios' => $usuarios ],
        JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR
    );
    exit();
}

/** @var Usuario $usuario */
foreach ($usuarios as $usuario) {
    echo $usuario . PHP_EOL;
}
