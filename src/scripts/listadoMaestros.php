<?php
/**
 * PHP version 7.2
 * doctrine_GCuest18 - listadoMaestros.php
 *
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

use TDW\GCuest\Entity\Maestro;

require 'inicio.php';

try {
    $entityManager = getEntityManager();
    $maestros = $entityManager->getRepository(Maestro::class)->findAll();
    $entityManager->close();
} catch (\Doctrine\ORM\ORMException $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}

/** @var Maestro $maestro */
foreach ($maestros as $maestro) {
    echo $maestro . PHP_EOL;
}
