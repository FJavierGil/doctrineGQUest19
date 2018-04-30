<?php
/**
 * PHP version 7.2
 * doctrine_GCuest18 - Cuestion.php
 *
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

namespace TDW\GCuest\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cuestion
 *
 * @package TDW\GCuest\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="cuestiones",
 *     indexes={
 *          @ORM\Index(
 *              name="fk_maestro_idx", columns={ "creador" }
 *          )
 *      }
 * )
 */
class Cuestion
{

    /**
     * @var int $idCuestion
     *
     * @ORM\Id()
     * @ORM\GeneratedValue( strategy="AUTO" )
     * @ORM\Column(
     *     name="idCuestion",
     *     type="integer"
     * )
     */
    protected $idCuestion;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(
     *     name="descripcion",
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected $descripcion;

    /**
     * @var bool $disponible
     *
     * @ORM\Column(
     *     name="disponible",
     *     type="integer",
     *     options={ "default" = 0 }
     * )
     */
    protected $disponible;

    /**
     * @var Maestro $creador
     *
     * @ORM\ManyToOne(targetEntity="Maestro", inversedBy="cuestiones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="creador", referencedColumnName="username")
     * })
     */
    protected $creador;

    /**
     * Cuestion constructor.
     *
     * @param string|null $descripcion
     * @param Maestro|null $creador
     * @param bool $disponible
     */
    public function __construct(?string $descripcion = '', ?Maestro $creador = null, bool $disponible = false)
    {
        $this->descripcion = $descripcion;
        $this->creador = $creador;
        $this->disponible = $disponible;
    }

    /**
     * @return int
     */
    public function getIdCuestion(): int
    {
        return $this->idCuestion;
    }

    /**
     * @return string
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     * @return Cuestion
     */
    public function setDescripcion(string $descripcion): Cuestion
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisponible(): bool
    {
        return $this->disponible;
    }

    /**
     * @param bool $disponible
     * @return Cuestion
     */
    public function setDisponible(bool $disponible): Cuestion
    {
        $this->disponible = $disponible;
        return $this;
    }

    /**
     * @return Maestro|null
     */
    public function getCreador(): ?Maestro
    {
        return $this->creador;
    }

    /**
     * @param Maestro $creador
     * @return Cuestion
     */
    public function setCreador(Maestro $creador): Cuestion
    {
        $this->creador = $creador;
        return $this;
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    public function __toString()
    {
        return '[ cuestion ' .
            '(id=' . $this->getIdCuestion() . ', ' .
            'descripción="' . $this->getDescripcion() . '", ' .
            'disponible=' . ($this->isDisponible() ? '1' : '0') . ', ' .
            'maestro=' . ($this->getCreador() ?? '[ - ]') .
            ') ]';
    }
}
