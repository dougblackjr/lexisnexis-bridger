<?php
namespace Tns\BridgerInsight\Services;

use SoapClient;
use Tns\BridgerInsight\Contracts\ScreeningClient;
use Tns\BridgerInsight\Dto\ScreeningRequest;
use Tns\BridgerInsight\Dto\ScreeningResponse;

final class ScreeningService implements ScreeningClient
{
    public function __construct(private SoapClient $soap) {}

    public function searchPerson(ScreeningRequest $req): ScreeningResponse
    {
        $payload = [
            'SearchType' => 'Person',
            'GivenName' => $req->givenName,
            'MiddleName' => $req->middleName,
            'Surname' => $req->surname,
            'DateOfBirth' => $req->dob?->format('Y-m-d'),
            'AddressLine1' => $req->addressLine1,
            'City' => $req->city,
            'Region' => $req->region,
            'PostalCode' => $req->postalCode,
            'Country' => $req->countryCode,
            'ReferenceId' => $req->referenceId,
        ];
        return $this->do('Search', $payload);
    }

    public function searchOrganization(ScreeningRequest $req): ScreeningResponse
    {
        $payload = [
            'SearchType' => 'Organization',
            'OrganizationName' => $req->organizationName ?? $req->surname,
            'RegistrationNumber' => $req->registrationNumber,
            'AddressLine1' => $req->addressLine1,
            'City' => $req->city,
            'Region' => $req->region,
            'PostalCode' => $req->postalCode,
            'Country' => $req->countryCode,
            'ReferenceId' => $req->referenceId,
        ];
        return $this->do('Search', $payload);
    }

    public function getResultById(string $resultId): ScreeningResponse
    {
        return $this->do('GetResult', ['ResultId' => $resultId]);
    }

    /** @return array<string, mixed> */
    public function rawCall(string $operation, array $payload): array
    {
        $result = $this->soap->__soapCall($operation, [$payload]);
        // Normalize to array
        $arr = json_decode(json_encode($result, JSON_PARTIAL_OUTPUT_ON_ERROR), true) ?: [];
        return $arr;
    }

    private function do(string $operation, array $payload): ScreeningResponse
    {
        $arr = $this->rawCall($operation, $payload);

        // Try to map a couple of common patterns; adjust after generation confirms shapes
        $normalized = [
            'resultId' => $arr['ResultId'] ?? ($arr['resultId'] ?? null),
            'status' => $arr['Status'] ?? ($arr['status'] ?? null),
            'hits' => $arr['Hits'] ?? ($arr['hits'] ?? []),
        ];
        return ScreeningResponse::fromArray($normalized);
    }
}
