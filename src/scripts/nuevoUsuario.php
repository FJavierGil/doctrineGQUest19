<?php
/**
 * PHP version 7.2
 * doctrine_GCuest18 - nuevoUsuario.php
 *
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

use TDW\GCuest\Entity\Usuario;

require 'inicio.php';

try {
    $nombre = 'user-' . mt_rand(0, 100000);
    $entityManager = getEntityManager();
    $usuario = new Usuario($nombre, $nombre . '@example.com', mt_rand(0, 1));
    $entityManager->persist($usuario);
    $entityManager->flush();
} catch (\Doctrine\ORM\ORMException $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}
