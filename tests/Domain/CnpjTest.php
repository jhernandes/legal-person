<?php

declare(strict_types=1);

use Jhernandes\LegalPerson\Domain\Cnpj;
use PHPUnit\Framework\TestCase;

class CnpjTest extends TestCase
{
    public function testCanCreateFromValidString(): void
    {
        $this->assertInstanceOf(
            Cnpj::class,
            Cnpj::fromString('44.925.276/0001-56')
        );
    }

    public function testCanCreateFromValidStringAndBeFormatted(): void
    {
        $this->assertSame(
            '44.925.276/0001-56',
            (string) Cnpj::fromString('44925276000156')
        );
    }

    public function testCannotCreateFromInvalidSizeString(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('123 is not a valid CNPJ [Invalid Size]');

        Cnpj::fromString('123');
    }

    public function testCannotCreateFromInvalidSequenceString(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('11111111111111 is not a valid CNPJ [Invalid Sequence]');

        Cnpj::fromString('11111111111111');
    }

    public function testCannotCreateFromInvalidFirstCheckDigitString(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('44925276000116 is not a valid CNPJ [Invalid first check digit]');

        Cnpj::fromString('44.925.276/0001-16');
    }

    public function testCannotCreateFromInvalidSecondCheckDigitString(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('44925276000151 is not a valid CNPJ [Invalid second check digit]');

        Cnpj::fromString('44.925.276/0001-51');
    }
}
