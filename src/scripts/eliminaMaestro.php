<?php
/**
 * PHP version 7.2
 * doctrine_GCuest18 - eliminaMaestro.php
 *
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

use TDW\GCuest\Entity\Maestro;

require 'inicio.php';

if ($argc != 2) {
    $texto = <<< ______MOSTRAR_USO
    *> Empleo: {$argv[0]} <idMaestro>
    Elimina el maestro indicado por <idMaestro>

______MOSTRAR_USO;
    die($texto);
}

try {
    $nombre = $argv[1];
    $entityManager = getEntityManager();
    $maestro = $entityManager
        ->find(Maestro::class, $nombre);
    if (null == $maestro) {
        die('Maestro [' . $nombre . '] no existe.' .PHP_EOL);
    }
    $entityManager->remove($maestro);
    $entityManager->flush();
} catch (\Doctrine\ORM\ORMException $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}
