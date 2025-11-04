<?php
namespace Tns\BridgerInsight\Dto;

use DateTimeImmutable;

final class ScreeningRequest
{
    public const TYPE_PERSON = 'Person';
    public const TYPE_ORGANIZATION = 'Organization';

    public string $type = self::TYPE_PERSON;

    // Common
    public ?string $referenceId = null;
    public ?string $countryCode = null;
    public ?string $addressLine1 = null;
    public ?string $addressLine2 = null;
    public ?string $city = null;
    public ?string $region = null;
    public ?string $postalCode = null;

    // Person
    public ?string $givenName = null;
    public ?string $middleName = null;
    public ?string $surname = null;
    public ?DateTimeImmutable $dob = null;

    // Organization
    public ?string $organizationName = null;
    public ?string $registrationNumber = null;

    public function person(): self { $this->type = self::TYPE_PERSON; return $this; }
    public function organization(): self { $this->type = self::TYPE_ORGANIZATION; return $this; }

    public function name(string $given = null, string $surname = null, string $middle = null): self {
        $this->givenName = $given;
        $this->surname = $surname;
        $this->middleName = $middle;
        return $this;
    }

    public function dob(string|DateTimeImmutable $dob): self {
        $this->dob = $dob instanceof DateTimeImmutable ? $dob : new DateTimeImmutable($dob);
        return $this;
    }

    public function address(string $line1 = null, string $city = null, string $region = null, string $postalCode = null, string $countryCode = null): self {
        $this->addressLine1 = $line1;
        $this->city = $city;
        $this->region = $region;
        $this->postalCode = $postalCode;
        $this->countryCode = $countryCode;
        return $this;
    }
}
