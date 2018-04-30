<?php
/**
 * PHP version 7.2
 * doctrine_GCuest18 - Usuario.php
 *
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

namespace TDW\GCuest\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Usuario
 *
 * @package TDW\GCuest\Entity
 */
class Usuario
{
    /**
     * @var string $username
     *
     * @ORM\Id()
     * @ORM\Column(
     *     name="username",
     *     type="string",
     *     length=32
     * )
     */
    protected $username;

    /**
     * @var string $email
     *
     * @ORM\Column(
     *     name="email",
     *     type="string",
     *     length=64,
     *     nullable=false
     * )
     */
    protected $email;

    /**
     * Usuario constructor.
     * @param string $username
     * @param string $email
     */
    public function __construct(string $username = '', string $email = '')
    {
        $this->username = $username;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Usuario
     */
    public function setUsername(string $username): Usuario
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Usuario
     */
    public function setEmail(string $email): Usuario
    {
        $this->email = $email;
        return $this;
    }
}
