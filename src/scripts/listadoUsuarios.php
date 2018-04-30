<?php
/**
 * PHP version 7.2
 * doctrine_GCuest18 - listadoMaestros.php
 *
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

use TDW\GCuest\Entity\Usuario;

require 'inicio.php';

try {
    $entityManager = getEntityManager();
    $usuarios = $entityManager->getRepository(Usuario::class)->findAll();
    $entityManager->close();
} catch (\Doctrine\ORM\ORMException $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}

// Salida formato JSON
if (in_array('--json', $argv)) {
    echo json_encode($usuarios, JSON_PRETTY_PRINT);
    exit();
}

/** @var Usuario $usuario */
foreach ($usuarios as $usuario) {
    echo $usuario . PHP_EOL;
}
