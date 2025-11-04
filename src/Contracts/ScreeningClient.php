<?php
namespace Tns\BridgerInsight\Contracts;

use Tns\BridgerInsight\Dto\ScreeningRequest;
use Tns\BridgerInsight\Dto\ScreeningResponse;

interface ScreeningClient
{
    public function searchPerson(ScreeningRequest $req): ScreeningResponse;
    public function searchOrganization(ScreeningRequest $req): ScreeningResponse;
    public function getResultById(string $resultId): ScreeningResponse;

    /** @return array<string, mixed> */
    public function rawCall(string $operation, array $payload): array;
}
