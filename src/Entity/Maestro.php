<?php
/**
 * PHP version 7.2
 * doctrine_GCuest18 - Maestro.php
 *
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

namespace TDW\GCuest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Maestro
 *
 * @package TDW\GCuest\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="maestros")
 */
class Maestro extends Usuario
{

    /**
     * @var Cuestion[] $cuestiones
     *
     * @ORM\OneToMany(
     *     targetEntity="Cuestion",
     *     mappedBy="creador"
     * )
     */
    protected $cuestiones;

    public function __construct(string $username = '', string $email = '')
    {
        parent::__construct($username, $email);
        $this->cuestiones = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getCuestiones(): Collection
    {
        return $this->cuestiones;
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    public function __toString(): string
    {
        $id_cuestiones = $this->getCuestiones()->getKeys();
        $txt_cuestiones = '[' . implode(', ', $id_cuestiones) . ']';
        return '[ maestro ' .
            '(username="' . $this->getUsername() . '"", ' .
            'email="' . $this->getEmail() . '"", ' .
            'cuestiones=' . $txt_cuestiones .
            ') ]';
    }
}
