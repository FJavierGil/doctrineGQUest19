<?php
/**
 * PHP version 7.4
 * src\scripts\eliminaCuestion.php
 */

use TDW\GCuest\Entity\Cuestion;
use TDW\GCuest\Utils;

require 'inicio.php';

if ($argc !== 2) {
    $texto = <<< ______MOSTRAR_USO
    *> Empleo: {$argv[0]} <idCuestion>
    Elimina la cuestión indicada por <idCuestion>

______MOSTRAR_USO;
    die($texto);
}

try {
    $idCuestion = filter_var($argv[1], FILTER_VALIDATE_INT);
    $entityManager = Utils::getEntityManager();
    $cuestion = $entityManager
        ->find(Cuestion::class, $idCuestion);
    if (null === $cuestion) {
        die('Cuestión [' . $idCuestion . '] no existe.' .PHP_EOL);
    }
    $entityManager->remove($cuestion);
    $entityManager->flush();
} catch (Throwable $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}
