<?php
/**
 * PHP version 7.2
 * doctrine_GCuest18 - nuevoMaestro.php
 *
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

use TDW\GCuest\Entity\Maestro;

require 'inicio.php';

try {
    $nombre = 'm-' . mt_rand(0, 100000);
    $entityManager = getEntityManager();
    $maestro = new Maestro($nombre, $nombre . '@example.com');
    $entityManager->persist($maestro);
    $entityManager->flush();
} catch (\Doctrine\ORM\ORMException $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}
