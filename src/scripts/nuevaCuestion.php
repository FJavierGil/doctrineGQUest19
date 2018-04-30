<?php
/**
 * PHP version 7.2
 * doctrine_GCuest18 - nuevoMaestro.php
 *
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

use TDW\GCuest\Entity\Cuestion;
use TDW\GCuest\Entity\Maestro;

require 'inicio.php';

if ($argc < 2) {
    $texto = <<< ______MOSTRAR_USO
    *> Empleo: {$argv[0]} <descripcion> <maestro> [<disponible=0>]
    Crea una nueva cuestión

______MOSTRAR_USO;
    die($texto);
}

try {
    $entityManager = getEntityManager();
    $maestro = $entityManager
        ->getRepository(Maestro::class)
        ->findOneBy([ 'username' => ($argv[2] ?? null) ]);
    if (isset($argv[2]) && null === $maestro) {
        throw new \Doctrine\ORM\EntityNotFoundException('Maestro no encontrado');
    }
    $cuestion = new Cuestion($argv[1], $maestro, $argv[3] ?? false);
    $entityManager->persist($cuestion);
    $entityManager->flush();
    echo 'Creada cuestión Id: ' . $cuestion->getIdCuestion() . PHP_EOL;
} catch (\Doctrine\ORM\ORMException $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}
