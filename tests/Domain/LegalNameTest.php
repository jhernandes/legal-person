<?php

declare(strict_types=1);

use Jhernandes\LegalPerson\Domain\LegalName;
use PHPUnit\Framework\TestCase;

class LegalNameTest extends TestCase
{
    public function testCanCreateFromValidString(): void
    {
        $this->assertInstanceOf(
            LegalName::class,
            LegalName::fromString('Empresa de Tecnologia Águia 42 LTDA ME')
        );
    }

    public function testCannotCreateFromInvalidString(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        LegalName::fromString('Empresa de Tecnologia #@42$ LTDA ME');
    }
}
