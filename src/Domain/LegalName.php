<?php

declare(strict_types=1);

namespace Jhernandes\LegalPerson\Domain;

class LegalName
{
    private string $name;

    public function __construct(string $name)
    {
        $name = trim($name);

        $this->ensureIsValidName($name);

        $this->name = $name;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function ensureIsValidName(string $name): void
    {
        foreach (explode(' ', $name) as $singlename) {
            if (!preg_match('/^[0-9a-zA-ZÀ-ÖØ-öø-ÿ]+$/', $singlename)) {
                throw new \UnexpectedValueException(
                    sprintf('%s is not a valid name', $name)
                );
            }
        }
    }
}
