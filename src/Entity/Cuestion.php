<?php

/**
 * PHP version 7.4
 * src/Entity/Cuestion.php
 */

namespace TDW\GCuest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\ORMException;
use JsonSerializable;

/**
 * Class Cuestion
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="cuestiones",
 *     indexes={
 *          @ORM\Index(
 *              name="fk_creador_idx",
 *              columns={ "creador" }
 *          )
 *      }
 * )
 */
class Cuestion implements JsonSerializable
{
    public const CUESTION_ABIERTA = 'abierta';
    public const CUESTION_CERRADA = 'cerrada';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(
     *     name="idCuestion",
     *     type="integer"
     * )
     */
    protected ?int $idCuestion;

    /**
     * @ORM\Column(
     *     name="enum_descripcion",
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected ?string $enunciadoDescripcion;

    /**
     * @ORM\Column(
     *     name="enum_disponible",
     *     type="boolean",
     *     options={ "default" = false }
     * )
     */
    protected bool $enunciadoDisponible;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Usuario",
     *     inversedBy="cuestiones",
     *     cascade={ "merge", "remove" }
     *     )
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(
     *     name="creador",
     *     referencedColumnName="id",
     *     nullable=true,
     *     onDelete="CASCADE"
     *   )
     * })
     */
    protected ?Usuario $creador = null;

    /**
     * @ORM\Column(
     *     name="estado",
     *     type="string",
     *     length=7,
     *     options={ "default" = Cuestion::CUESTION_CERRADA }
     * )
     */
    protected string $estado = Cuestion::CUESTION_CERRADA;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="Categoria",
     *     mappedBy="cuestiones"
     * )
     * @ORM\OrderBy({ "idCategoria" = "ASC" })
     */
    protected Collection $categorias;

    /**
     * Cuestion constructor.
     *
     * @param string|null  $enunciadoDescripcion
     * @param Usuario|null $creador
     * @param bool         $enunciadoDisponible
     *
     * @throws ORMException
     */
    public function __construct(
        ?string $enunciadoDescripcion = null,
        ?Usuario $creador = null,
        bool $enunciadoDisponible = false
    ) {
        $this->idCuestion = 0;
        $this->enunciadoDescripcion = $enunciadoDescripcion;
        (null !== $creador)
            ? $this->setCreador($creador)
            : null;
        $this->enunciadoDisponible = $enunciadoDisponible;
        $this->estado = self::CUESTION_CERRADA;
        $this->categorias = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdCuestion(): int
    {
        return (int) $this->idCuestion;
    }

    /**
     * @return string
     */
    public function getEnunciadoDescripcion(): string
    {
        return (string) $this->enunciadoDescripcion;
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
     * @throws ORMException
     */
    public function setCreador(Usuario $creador): Cuestion
    {
        if (!$creador->isMaestro()) {
            throw new ORMException('Creador debe ser maestro');
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
        $this->estado = self::CUESTION_ABIERTA;
        return $this;
    }

    /**
     * @return Cuestion
     */
    public function cerrarCuestion(): Cuestion
    {
        $this->estado = self::CUESTION_CERRADA;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCategorias(): Collection
    {
        return $this->categorias;
    }

    /**
     * @param Categoria $categoria
     * @return bool
     */
    public function containsCategoria(Categoria $categoria): bool
    {
        return $this->categorias->contains($categoria);
    }

    /**
     * Añade la categoría a la cuestión
     *
     * @param Categoria $categoria
     * @return Cuestion
     */
    public function addCategoria(Categoria $categoria): Cuestion
    {
        if ($this->categorias->contains($categoria)) {
            return $this;
        }

        $this->categorias->add($categoria);
        return $this;
    }

    /**
     * Elimina la categoría identificado por $categoria de la cuestión
     *
     * @param Categoria $categoria
     * @return Cuestion|null La cuestión o nulo, si la cuestión no contiene la categoría
     */
    public function removeCategoria(Categoria $categoria): ?Cuestion
    {
        if (!$this->categorias->contains($categoria)) {
            return null;
        }

        $this->categorias->removeElement($categoria);
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
        $cod_categorias = $this->getCategorias()->isEmpty()
            ? new ArrayCollection()
            : $this->getCategorias()->map(
                fn (Categoria $categoria) => $categoria->getIdCategoria()
            );
        $txt_categorias = $cod_categorias->isEmpty()
            ? '[ ]'
            : '[' . implode(', ', $cod_categorias->getValues()) . ']';
        return '[ cuestion ' .
            '(id=' . $this->getIdCuestion() . ', ' .
            'enum_descripción="' . $this->getEnunciadoDescripcion() . '", ' .
            'enum_disponible=' . ($this->isEnunciadoDisponible() ? '1' : '0') . ', ' .
            'creador=' . ($this->getCreador() ?? '[ - ]') . ', ' .
            'estado="' . $this->getEstado() . '" ' .
            'categorias=' . $txt_categorias .
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
        $cod_categorias = $this->getCategorias()->isEmpty()
            ? new ArrayCollection()
            : $this->getCategorias()->map(
                fn (Categoria $plan) => $plan->getIdCategoria()
            );
        return [
            'cuestion' => [
                'idCuestion' => $this->getIdCuestion(),
                'enum_descripcion' => utf8_encode($this->getEnunciadoDescripcion()),
                'enum_disponible' => $this->isEnunciadoDisponible(),
                'creador' => $this->getCreador(),
                'estado' => $this->getEstado(),
                'categorias' => $cod_categorias->toArray(),
            ]
        ];
    }
}
