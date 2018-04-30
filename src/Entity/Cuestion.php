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
 *              name="fk_creador_idx", columns={ "creador" }
 *          )
 *      }
 * )
 */
class Cuestion implements \JsonSerializable
{

    const CUESTION_ABIERTA = 'abierta';
    const CUESTION_CERRADA = 'cerrada';

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
     * @var string $enunciadoDescripcion
     *
     * @ORM\Column(
     *     name="enum_descripcion",
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected $enunciadoDescripcion;

    /**
     * @var bool $disponible
     *
     * @ORM\Column(
     *     name="enum_disponible",
     *     type="integer",
     *     options={ "default" = 0 }
     * )
     */
    protected $enunciadoDisponible;

    /**
     * @var Usuario $creador
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="cuestiones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="creador", referencedColumnName="username")
     * })
     */
    protected $creador = null;

    /**
     * @var string $estado
     *
     * @ORM\Column(
     *     name="estado",
     *     type="string",
     *     length=7,
     *     options={ "default" = Cuestion::CUESTION_CERRADA }
     * )
     */
    protected $estado = Cuestion::CUESTION_CERRADA;

    /**
     * Cuestion constructor.
     *
     * @param string|null $enunciadoDescripcion
     * @param Usuario|null $creador
     * @param bool $enunciadoDisponible
     * @throws \Doctrine\Common\CommonException
     */
    public function __construct(
        ?string $enunciadoDescripcion = '',
        ?Usuario $creador = null,
        bool $enunciadoDisponible = false
    ) {
        $this->enunciadoDescripcion = $enunciadoDescripcion;
        (null != $creador)
            ? $this->setCreador($creador)
            : null;
        $this->enunciadoDisponible = $enunciadoDisponible;
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
    public function getEnunciadoDescripcion(): string
    {
        return $this->enunciadoDescripcion;
    }

    /**
     * @param string $enunciadoDescripcion
     * @return Cuestion
     */
    public function setEnunciadoDescripcion(string $enunciadoDescripcion): Cuestion
    {
        $this->enunciadoDescripcion = $enunciadoDescripcion;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnunciadoDisponible(): bool
    {
        return $this->enunciadoDisponible;
    }

    /**
     * @param bool $disponible
     * @return Cuestion
     */
    public function setEnunciadoDisponible(bool $disponible): Cuestion
    {
        $this->enunciadoDisponible = $disponible;
        return $this;
    }

    /**
     * @return Usuario|null
     */
    public function getCreador(): ?Usuario
    {
        return $this->creador;
    }

    /**
     * @param Usuario $creador
     * @return Cuestion
     * @throws \Doctrine\Common\CommonException
     */
    public function setCreador(Usuario $creador): Cuestion
    {
        if (!$creador->esMaestro()) {
            throw new \Doctrine\Common\CommonException('Creador debe ser maestro');
        }
        $this->creador = $creador;
        return $this;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @return Cuestion
     */
    public function abrirCuestion(): Cuestion
    {
        $this->estado = Cuestion::CUESTION_ABIERTA;
        return $this;
    }

    /**
     * @return Cuestion
     */
    public function cerrarCuestion(): Cuestion
    {
        $this->estado = Cuestion::CUESTION_CERRADA;
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
            'enum_descripción="' . $this->getEnunciadoDescripcion() . '", ' .
            'enum_disponible=' . ($this->isEnunciadoDisponible() ? '1' : '0') . ', ' .
            'creador=' . ($this->getCreador() ?? '[ - ]') . ', ' .
            'estado="' . $this->getEstado() . '"' .
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
        return [
            'cuestion' => [
                'idCuestion' => $this->getIdCuestion(),
                'enum_descripcion' => $this->getEnunciadoDescripcion(),
                'enum_disponible' => $this->isEnunciadoDisponible(),
                'creador' => $this->getCreador(),
                'estado' => $this->getEstado(),
            ]
        ];
    }
}
