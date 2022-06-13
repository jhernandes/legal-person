<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\LegalPerson\Domain\LegalPerson;

class LegalPersonTest extends TestCase
{
    public function testCanCreateFromValidString(): void
    {
        $legalPerson = LegalPerson::fromString(
            'Empresa de Tecnologia Águia 42 LTDA ME',
            'Águia 42 TI',
            '31.901.315/0001-33',
            'contato@aguia.com.br'
        );

        $this->assertInstanceOf(
            LegalPerson::class,
            $legalPerson
        );

        $this->assertIsArray($legalPerson->jsonSerialize());
    }

    public function testCanAccessAsArray(): void
    {
        $legalPerson = LegalPerson::fromString(
            'Empresa de Tecnologia Águia 42 LTDA ME',
            'Águia 42 TI',
            '31.901.315/0001-33',
            'contato@aguia.com.br'
        );

        $legalPerson->setPhone('11 3000-1000');
        $legalPerson->setMobilePhone('11 93000-1000');
        $legalPerson->setAddress('Rua Teste, 1234, Centro, Sala 561 5 Andar, São Paulo, SP, 01000-123');
        $legalPerson->setPartner('Marco Antonio', '304.617.600-70');

        $this->assertSame(
            [
                'legalName' => 'Empresa de Tecnologia Águia 42 LTDA ME',
                'fantasyName' => 'Águia 42 TI',
                'cnpj' => '31.901.315/0001-33',
                'email' => 'contato@aguia.com.br',
                'phone' => '(11) 3000-1000',
                'mobilePhone' => '(11) 93000-1000',
                'address' => [
                    'street' => 'Rua Teste',
                    'number' => '1234',
                    'complement' => 'Sala 561 5 Andar',
                    'district' => 'Centro',
                    'city' => 'São Paulo',
                    'state' => 'SP',
                    'cep' => '01000-123',
                ],
                'partner' => [
                    'name' => 'Marco Antonio',
                    'cpf' => '304.617.600-70',
                    'birthdate' => '',
                    'email' => '',
                    'contacts' => [
                        'mobilePhone' => '',
                        'homePhone' => '',
                    ],
                    'address' => null,
                ],

            ],
            $legalPerson->jsonSerialize()
        );
    }
}
