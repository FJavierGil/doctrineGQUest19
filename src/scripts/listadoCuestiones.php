<?php

/**
 * PHP version 7.4
 * src/scripts/listadoCuestiones.php
 *
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

use TDW\GCuest\Entity\Cuestion;
use TDW\GCuest\Utility\Utils;

require 'inicio.php';

try {
    $entityManager = Utils::getEntityManager();
    $cuestiones = $entityManager->getRepository(Cuestion::class)->findAll();
    $entityManager->close();
} catch (Throwable $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}

// Salida formato JSON
if (in_array('--json', $argv, false)) {
    echo json_encode(
        [ 'cuestiones' => $cuestiones ],
        JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR
    );
    exit();
}

/** @var Cuestion $cuestion */
foreach ($cuestiones as $cuestion) {
    echo $cuestion . PHP_EOL;
}
