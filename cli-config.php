<?php
/**
 * PHP version 7.2
 * \cli-config.php
 *
 * @category Doctrine
 * @package  TDW\\GCuest
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();
$dotenv->required(
    [
    'DATABASE_HOST',
    'DATABASE_NAME',
    'DATABASE_USER',
    'DATABASE_PASSWD',
    'DATABASE_DRIVER'
    ]
);

require_once __DIR__ . '/bootstrap.php';

try {
    $entityManager = getEntityManager();
} catch (\Doctrine\ORM\ORMException $e) {
    exit('ERROR (' . $e->getCode() . '): ' . $e->getMessage());
}

return ConsoleRunner::createHelperSet($entityManager);
