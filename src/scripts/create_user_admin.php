<?php

/**
 * PHP version 7.4
 * src/scripts/create_user_admin.php
 */

require_once __DIR__ . '/inicio.php';

use TDW\GCuest\Entity\Usuario;
use TDW\GCuest\Utility\Utils;

// Crear usuario
$user = new Usuario();
$user->setUsername($_ENV['ADMIN_USER_NAME']);
$user->setEmail($_ENV['ADMIN_USER_EMAIL']);
$user->setPassword($_ENV['ADMIN_USER_PASSWD']);
$user->setEnabled(true);
$user->setAdmin(true);
$user->setMaestro(true);

try {
    $em = Utils::getEntityManager();
    $em->persist($user);
    $em->flush();
    fwrite(
        STDOUT,
        sprintf('Creado usuario Id: %d' . PHP_EOL, $user->getId())
    );
} catch (Throwable $e) {
    die('ERROR: ' . $e->getMessage());
}
