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
     * @var integer $attr1
     *
     * @ORM\Column(
     *     name="attr1",
     *     type="integer",
     *     nullable=true
     * )
     */
    protected $attr1;

    public function __construct(string $username = '', string $email = '', int $attr1 = 0)
    {
        parent::__construct($username, $email);
        $this->attr1 = $attr1;
    }

    /**
     * @return int
     */
    public function getAttr1(): int
    {
        return $this->attr1;
    }

    /**
     * @param int $attr1
     * @return Maestro
     */
    public function setAttr1(int $attr1): Maestro
    {
        $this->attr1 = $attr1;
        return $this;
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    public function __toString(): string
    {
        return '[ maestro ' .
            '(username=' . $this->getUsername() . ', ' .
            'email=' . $this->getEmail() .
            ') ]';
    }
}
