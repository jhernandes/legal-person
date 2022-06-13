<?php

declare(strict_types=1);

namespace Jhernandes\LegalPerson\Domain;

use Jhernandes\Person\Domain\Name;
use Jhernandes\Person\Domain\Person;
use Jhernandes\Contacts\Domain\Email;
use Jhernandes\Contacts\Domain\Phone;
use Jhernandes\BrazilianAddress\Domain\Address;

class LegalPerson implements \JsonSerializable
{
    private LegalName $legalName;
    private LegalName $fantasyName;
    private Cnpj $cnpj;
    private Phone $phone;
    private Phone $mobilePhone;
    private Email $email;
    private Address $address;
    private Person $partner;

    public function __construct(
        string $legalName,
        string $fantasyName,
        string $cnpj,
        ?string $email = null
    ) {
        $this->legalName = LegalName::fromString($legalName);
        $this->fantasyName = LegalName::fromString($fantasyName);
        $this->cnpj = Cnpj::fromString($cnpj);

        if ($email !== null) {
            $this->email = Email::fromString($email);
        }
    }

    public static function fromString(
        string $legalName,
        string $fantasyName,
        string $cnpj,
        ?string $email = null
    ): self {
        return new self($legalName, $fantasyName, $cnpj, $email);
    }

    public function jsonSerialize(): array
    {
        return [
            'legalName' => (string)$this->legalName,
            'fantasyName' => (string) $this->fantasyName,
            'cnpj' => (string) $this->cnpj,
            'email' => (string) (isset($this->email) ? $this->email : ''),
            'phone' => (string) (isset($this->phone) ? $this->phone : ''),
            'mobilePhone' => (string) (isset($this->mobilePhone) ? $this->mobilePhone : ''),
            'address' => isset($this->address) ? $this->address->jsonSerialize() : null,
            'partner' => isset($this->partner) ? $this->partner->jsonSerialize() : null
        ];
    }

    public function setPhone(string $phone): void
    {
        $this->phone = Phone::fromString($phone);
    }

    public function setMobilePhone(string $mobilePhone): void
    {
        $this->mobilePhone = Phone::fromString($mobilePhone);
    }

    public function setEmail(string $email): void
    {
        $this->email = Email::fromString($email);
    }

    public function setAddress(string $address): void
    {
        $this->address = Address::fromString($address);
    }

    public function setPartner(string $name, string $cpf): void
    {
        $this->partner = Person::fromString($name, $cpf);
    }
}
