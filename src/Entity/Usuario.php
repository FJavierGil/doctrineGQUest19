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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Usuario
 *
 * @package TDW\GCuest\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="usuarios")
 */
class Usuario implements \JsonSerializable
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
     *     nullable=true
     * )
     */
    protected $email;

    /**
     * @var bool
     *
     * @ORM\Column(
     *     name="esMaestro",
     *     type="integer",
     *     options={ "default" = 0}
     * )
     */
    protected $esMaestro = false;

    /**
     * @var Cuestion[] $cuestiones
     *
     * @ORM\OneToMany(
     *     targetEntity="Cuestion",
     *     mappedBy="creador"
     * )
     */
    protected $cuestiones;

    /**
     * Usuario constructor.
     * @param string $username
     * @param string $email
     * @param bool $esMaestro
     */
    public function __construct(string $username = '', string $email = '', bool $esMaestro = false)
    {
        $this->username = $username;
        $this->email = $email;
        $this->esMaestro = $esMaestro;
        $this->cuestiones = new ArrayCollection();
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

    /**
     * @return bool
     */
    public function esMaestro(): bool
    {
        return $this->esMaestro;
    }

    /**
     * @param bool $esMaestro
     * @return Usuario
     */
    public function setMaestro(bool $esMaestro): Usuario
    {
        $this->esMaestro = $esMaestro;
        return $this;
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
        $id_cuestiones = $this->getCuestiones()->map(
            function (Cuestion $cuestion) {
                return $cuestion->getIdCuestion();
            }
        );
        $txt_cuestiones = '[' . implode(', ', $id_cuestiones->getValues()) . ']';
        return '[ usuario ' .
            '(username="' . $this->getUsername() . '", ' .
            'email="' . $this->getEmail() . '", ' .
            'esMaestro="' . ($this->esMaestro() ? '1' : '0') . '", ' .
            'cuestiones=' . $txt_cuestiones .
            ') ]';
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $id_cuestiones = $this->getCuestiones()->map(
            function (Cuestion $cuestion) {
                return $cuestion->getIdCuestion();
            }
        );
        return [
            'usuario' => [
                'username' => $this->getUsername(),
                'email' => $this->getEmail(),
                'esMaestro' => $this->esMaestro(),
                'cuestiones' => $id_cuestiones->getValues()
            ]
        ];
    }
}
