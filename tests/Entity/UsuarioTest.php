<?php
/**
 * PHP version 7.4
 * src\Entity\Usuario.php
 */

namespace TDW\Tests\GCuest\Entity;

use Faker\Factory;
use Faker\Generator as Faker;
use PHPUnit\Framework\TestCase;
use TDW\GCuest\Entity\Cuestion;
use TDW\GCuest\Entity\Usuario;

/**
 * Class UserTest
 *
 * @group   users
 * @coversDefaultClass \TDW\GCuest\Entity\Usuario
 */
class UsuarioTest extends TestCase
{
    protected static Usuario $user;

    private static Faker $faker;

    private static Cuestion $cuestion;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     */
    public static function setUpBeforeClass(): void
    {
        self::$user  = new Usuario();
        self::$faker = Factory::create('es_ES');
        self::$cuestion = new Cuestion();
    }

    /**
     * @covers ::__construct()
     *
     * @return void
     */
    public function testConstructor(): void
    {
        self::$user = new Usuario();
        self::assertSame(0, self::$user->getId());
        self::assertEmpty(self::$user->getUsername());
        self::assertEmpty(self::$user->getEmail());
        self::assertTrue(self::$user->isEnabled());
        self::assertFalse(self::$user->isMaestro());
        self::assertFalse(self::$user->isAdmin());
    }

    /**
     * @covers ::getId()
     */
    public function testGetId(): void
    {
        self::assertSame(0, self::$user->getId());
    }

    /**
     * @covers ::setUsername()
     * @covers ::getUsername()
     */
    public function testGetSetUsername(): void
    {
        static::assertEmpty(self::$user->getUsername());
        $username = self::$faker->userName;
        self::$user->setUsername($username);
        static::assertSame($username, self::$user->getUsername());
    }

    /**
     * @covers ::getEmail()
     * @covers ::setEmail()
     */
    public function testGetSetEmail(): void
    {
        $userEmail = self::$faker->email;
        static::assertEmpty(self::$user->getEmail());
        self::$user->setEmail($userEmail);
        static::assertSame($userEmail, self::$user->getEmail());
    }

    /**
     * @covers ::setEnabled()
     * @covers ::isEnabled()
     */
    public function testIsSetEnabled(): void
    {
        self::$user->setEnabled(true);
        self::assertTrue(self::$user->isEnabled());

        self::$user->setEnabled(false);
        self::assertFalse(self::$user->isEnabled());
    }

    /**
     * @covers ::setAdmin()
     * @covers ::isAdmin()
     */
    public function testIsSetAdmin(): void
    {
        self::$user->setAdmin(true);
        self::assertTrue(self::$user->isAdmin());

        self::$user->setAdmin(false);
        self::assertFalse(self::$user->isAdmin());
    }

    /**
     * @covers ::setMaestro()
     * @covers ::isMaestro()
     */
    public function testIsSetMaestro(): void
    {
        self::$user->setMaestro(true);
        self::assertTrue(self::$user->isMaestro());

        self::$user->setMaestro(false);
        self::assertFalse(self::$user->isMaestro());
    }

    /**
     * @covers ::getPassword()
     * @covers ::setPassword()
     * @covers ::validatePassword()
     */
    public function testGetSetPassword(): void
    {
        $password = self::$faker->password;
        self::$user->setPassword($password);
        self::assertTrue(password_verify($password, self::$user->getPassword()));
        self::assertTrue(self::$user->validatePassword($password));
    }

    /**
     * @covers ::getCuestiones()
     */
    public function testGetCuestiones(): void
    {
        self::assertTrue(self::$user->getCuestiones()->isEmpty());
    }

    /**
     * @covers ::__toString()
     */
    public function testToString(): void
    {
        $username = self::$faker->userName;
        self::$user->setUsername($username);
        self::$user->setMaestro(true);
        self::$cuestion->setCreador(self::$user);
        self::assertStringContainsString($username, self::$user->__toString());
    }

    /**
     * @covers ::jsonSerialize()
     */
    public function testJsonSerialize(): void
    {
        self::$user->setMaestro(true);
        self::$cuestion->setCreador(self::$user);
        $json = json_encode(self::$user, JSON_THROW_ON_ERROR);
        self::assertJson((string) $json);
    }
}
