<?php
/**
 * PHP version 7.4
 * src\scripts\nuevaCuestion.php
 */

use TDW\GCuest\Entity\Cuestion;
use TDW\GCuest\Entity\Usuario;
use TDW\GCuest\Utils;

require 'inicio.php';

if ($argc < 2) {
    $texto = <<< ______MOSTRAR_USO
    *> Empleo: {$argv[0]} <descripcion> <maestro> [<disponible=0>]
    Crea una nueva cuestión

______MOSTRAR_USO;
    die($texto);
}

try {
    $maestro = null;
    $entityManager = Utils::getEntityManager();
    if (isset($argv[2])) {
        /** @var Usuario $maestro */
        $maestro = $entityManager
            ->getRepository(Usuario::class)
            ->findOneBy([ 'username' => $argv[2] ?? null ]);
        if (null === $maestro) {
            fwrite(STDERR, 'Maestro no encontrado' . PHP_EOL);
            exit(1);
        }
    }
    $cuestion = new Cuestion($argv[1], $maestro, $argv[3] ?? false);
    $entityManager->persist($cuestion);
    $entityManager->flush();
    echo 'Creada cuestión Id: ' . $cuestion->getIdCuestion() . PHP_EOL;
} catch (Throwable $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}
