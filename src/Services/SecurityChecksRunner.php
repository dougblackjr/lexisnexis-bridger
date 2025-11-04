<?php
namespace Tns\BridgerInsight\Services;

use Tns\BridgerInsight\Dto\ScreeningRequest;

final class SecurityChecksRunner
{
    public function __construct(private ScreeningService $svc) {}

    /**
     * Run a battery of security checks (sanctions, PEPs, adverse media, etc.).
     * Exact behavior depends on your Bridger configuration; tune profiles in code or config.
     *
     * @return array<string, mixed>
     */
    public function runAll(ScreeningRequest $req): array
    {
        $results = [];

        if ($req->type === 'Person') {
            $search = $this->svc->searchPerson($req);
        } else {
            $search = $this->svc->searchOrganization($req);
        }
        $results['search'] = [
            'resultId' => $search->resultId,
            'status' => $search->status,
            'hits' => $search->hits,
        ];

        // If your tenant exposes more granular operations (e.g., SanctionsOnly, PEPOnly),
        // call them here (examples shown; replace with actual operations post-generation).
        // $results['sanctions'] = $this->svc->rawCall('SanctionsCheck', $payload);
        // $results['pep']       = $this->svc->rawCall('PEPCheck', $payload);
        // $results['adverse']   = $this->svc->rawCall('AdverseMediaCheck', $payload);

        // Retrieve final normalized result (if applicable)
        if ($search->resultId) {
            $results['result'] = $this->svc->getResultById($search->resultId);
        }

        return $results;
    }
}
