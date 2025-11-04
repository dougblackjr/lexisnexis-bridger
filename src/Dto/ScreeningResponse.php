<?php
namespace Tns\BridgerInsight\Dto;

final class ScreeningResponse
{
    /** @var array<int, array<string, mixed>> */
    public array $hits = [];
    public ?string $resultId = null;
    public ?string $status = null;

    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->resultId = $data['resultId'] ?? null;
        $self->status = $data['status'] ?? null;
        $self->hits = $data['hits'] ?? [];
        return $self;
    }
}
