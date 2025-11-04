<?php
namespace Tns\BridgerInsight\Services;

use SoapClient;

final class Factory
{
    public function __construct(private SoapClient $soap) {}

    public function screening(): ScreeningService
    {
        return new ScreeningService($this->soap);
    }

    public function securityChecks(): SecurityChecksRunner
    {
        return new SecurityChecksRunner($this->screening());
    }
}
