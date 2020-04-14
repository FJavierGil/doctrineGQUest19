<?php

/**
 * PHP version 7.4
 * src/Entity/Usuario.php
 */

namespace TDW\GCuest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * User
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name                 = "usuarios",
 *     uniqueConstraints    = {
 *          @ORM\UniqueConstraint(
 *              name="IDX_UNIQ_USER", columns={ "username" }
 *          ),
 *          @ORM\UniqueConstraint(
 *              name="IDX_UNIQ_EMAIL", columns={ "email" }
 *          )
 *      }
 *     )
 */
class Usuario implements JsonSerializable
{
    /**
     * @ORM\Column(
     *     name     = "id",
     *     type     = "integer",
     *     nullable = false
     *     )
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    private ?int $id;

    /**
     * @ORM\Column(
     *     name     = "username",
     *     type     = "string",
     *     length   = 32,
     *     nullable = false,
     *     unique   = true
     *     )
     */
    private string $username;

    /**
     * @ORM\Column(
     *     name     = "email",
     *     type     = "string",
     *     length   = 60,
     *     nullable = false,
     *     unique   = true
     *     )
     */
    private string $email;

    /**
     * @ORM\Column(
     *     name     = "enabled",
     *     type     = "boolean",
     *     nullable = false
     *     )
     */
    private bool $enabled;

    /**
     * @ORM\Column(
     *     name="master",
     *     type="boolean",
     *     options={ "default" = false }
     * )
     */
    protected bool $isMaestro = false;

    /**
     * @ORM\Column(
     *     name     = "admin",
     *     type     = "boolean",
     *     nullable = true,
     *     options  = { "default" = false }
     *     )
     */
    private bool $isAdmin;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Cuestion",
     *     mappedBy="creador",
     *     cascade={ "merge", "remove" }
     * )
     */
    protected Collection $cuestiones;

    /**
     * @ORM\Column(
     *     name     = "password",
     *     type     = "string",
     *     length   = 60,
     *     nullable = false
     *     )
     */
    private string $password;

    /**
     * User constructor.
     *
     * @param string $username username
     * @param string $email email
     * @param string $password password
     * @param bool $enabled enabled
     * @param bool $isMaestro isMaestro
     * @param bool $isAdmin isAdmin
     */
    public function __construct(
        string $username = '',
        string $email = '',
        string $password = '',
        bool   $enabled = true,
        bool   $isMaestro = false,
        bool   $isAdmin = false
    ) {
        $this->id       = 0;
        $this->username = $username;
        $this->email    = $email;
        $this->setPassword($password);
        $this->enabled  = $enabled;
        $this->isMaestro = $isMaestro;
        $this->isAdmin  = $isAdmin;
        $this->cuestiones = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username username
     *
     * @return Usuario
     */
    public function setUsername(string $username): Usuario
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email email
     *
     * @return Usuario
     */
    public function setEmail(string $email): Usuario
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get isEnabled
     *
     * @return boolean
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled enabled
     *
     * @return Usuario
     */
    public function setEnabled(bool $enabled): Usuario
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * Set isAdmin
     *
     * @param boolean $isAdmin isAdmin
     *
     * @return Usuario
     */
    public function setAdmin(bool $isAdmin): Usuario
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMaestro(): bool
    {
        return $this->isMaestro;
    }

    /**
     * @param bool $esMaestro
     * @return Usuario
     */
    public function setMaestro(bool $esMaestro): Usuario
    {
        $this->isMaestro = $esMaestro;
        return $this;
    }

    /**
     * Get password hash
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string $password password
     *
     * @return Usuario
     */
    public function setPassword(string $password): Usuario
    {
        $this->password = (string) password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Verifies that the given hash matches the user password.
     *
     * @param string $password password
     *
     * @return boolean
     */
    public function validatePassword($password): bool
    {
        return password_verify($password, $this->password);
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
        /** @var ArrayCollection $id_cuestiones */
        $id_cuestiones = $this->getCuestiones()->isEmpty()
            ? new ArrayCollection()
            : $this->getCuestiones()->map(
                fn (Cuestion $cuestion) => $cuestion->getIdCuestion()
            );

        $txt_cuestiones = $id_cuestiones->isEmpty()
            ? '[ ]'
            : '[' . implode(', ', $id_cuestiones->getValues()) . ']';
        return '[ usuario ' .
            '(id=' . $this->getId() . ', ' .
            'username="' . $this->getUsername() . '", ' .
            'email="' . $this->getEmail() . '", ' .
            'enabled="' . ($this->isEnabled() ? '1' : '0') . '", ' .
            'isMaestro="' . ($this->isMaestro() ? '1' : '0') . '", ' .
            'isAdmin="' . ($this->isAdmin() ? '1' : '0') . '", ' .
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
        $id_cuestiones = $this->getCuestiones()->isEmpty()
            ? new ArrayCollection()
            : $this->getCuestiones()->map(
                fn (Cuestion $cuestion) => $cuestion->getIdCuestion()
            );

        return [
            'usuario' => [
                'id' => $this->getId(),
                'username' => utf8_encode($this->getUsername()),
                'email' => $this->getEmail(),
                'enabled' => $this->isEnabled(),
                'maestro' => $this->isMaestro(),
                'admin' => $this->isAdmin(),
                'cuestiones' => $id_cuestiones->getValues()
            ]
        ];
    }
}
