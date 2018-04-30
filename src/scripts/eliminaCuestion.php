<?php
/**
 * PHP version 7.2
 * doctrine_GCuest18 - eliminaUsuario.php
 *
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

use TDW\GCuest\Entity\Cuestion;

require 'inicio.php';

if ($argc != 2) {
    $texto = <<< ______MOSTRAR_USO
    *> Empleo: {$argv[0]} <idCuestion>
    Elimina la cuestión indicada por <idCuestion>

______MOSTRAR_USO;
    die($texto);
}

try {
    $idCuestion = filter_var($argv[1], FILTER_VALIDATE_INT);
    $entityManager = getEntityManager();
    $usuario = $entityManager
        ->find(Cuestion::class, $idCuestion);
    if (null == $usuario) {
        die('Cuestión [' . $idCuestion . '] no existe.' .PHP_EOL);
    }
    $entityManager->remove($usuario);
    $entityManager->flush();
} catch (\Doctrine\ORM\ORMException $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}
