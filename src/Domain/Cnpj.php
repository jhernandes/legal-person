<?php

declare(strict_types=1);

namespace Jhernandes\LegalPerson\Domain;

class Cnpj
{
    private string $cnpj;

    public function __construct(string $cnpj)
    {
        $cnpj = preg_replace('/\D/', '', (string) $cnpj);

        $this->ensureIsValid($cnpj);

        $this->cnpj = $cnpj;
    }

    public static function fromString(string $cnpj): self
    {
        return new self($cnpj);
    }

    public function __toString(): string
    {
        return $this->formatted();
    }

    public function formatted(): string
    {
        return sprintf(
            '%s.%s.%s/%s-%s',
            substr($this->cnpj, 0, 2),
            substr($this->cnpj, 2, 3),
            substr($this->cnpj, 5, 3),
            substr($this->cnpj, 8, 4),
            substr($this->cnpj, 12, 2)
        );
    }

    private function ensureIsValid(string $cnpj): void
    {
        // Valida tamanho
        if (strlen($cnpj) !== 14) {
            throw new \UnexpectedValueException(
                sprintf('%s is not a valid CNPJ [Invalid Size]', $cnpj)
            );
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 11111111111111
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            throw new \UnexpectedValueException(
                sprintf('%s is not a valid CNPJ [Invalid Sequence]', $cnpj)
            );
        }

        $cnpjAsArray = array_map(fn ($digit) => (int) $digit, str_split($cnpj));

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += (int) $cnpjAsArray[$i] * $j;
            $j = ($j === 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;
        if ($cnpjAsArray[12] !== ($resto < 2 ? 0 : 11 - $resto)) {
            throw new \UnexpectedValueException(
                sprintf('%s is not a valid CNPJ [Invalid first check digit]', $cnpj)
            );
        }

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpjAsArray[$i] * $j;
            $j = ($j === 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;
        if (!($cnpjAsArray[13] === ($resto < 2 ? 0 : 11 - $resto))) {
            throw new \UnexpectedValueException(
                sprintf('%s is not a valid CNPJ [Invalid second check digit]', $cnpj)
            );
        }
    }
}
