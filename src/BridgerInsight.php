<?php
namespace Tns\BridgerInsight;

use Tns\BridgerInsight\Soap\RuntimeSoapClient;
use Tns\BridgerInsight\Soap\WsseMiddleware;
use Tns\BridgerInsight\Services\ScreeningService;
use Tns\BridgerInsight\Services\SecurityChecksRunner;

final class BridgerInsight
{
    private function __construct(
        private Services\Factory $factory
    ) {}

    public static function fromEnv(): self
    {
        $wsdl = getenv('BRIDGER_WSDL') ?: '';
        $clientId = getenv('BRIDGER_CLIENT_ID') ?: '';
        $userId = getenv('BRIDGER_USER_ID') ?: '';
        $password = getenv('BRIDGER_PASSWORD') ?: '';
        $timeout = (int) (getenv('BRIDGER_TIMEOUT') ?: 15);
        $cacheWsdl = (int) (getenv('BRIDGER_CACHE_WSDL') ?: 1);

        $soap = RuntimeSoapClient::make($wsdl, [
            'connection_timeout' => $timeout,
            'cache_wsdl' => $cacheWsdl ? WSDL_CACHE_BOTH : WSDL_CACHE_NONE,
        ]);
        $soap->__setSoapHeaders([ WsseMiddleware::usernameToken($clientId, $userId, $password) ]);

        $factory = new Services\Factory($soap);
        return new self($factory);
    }

    public function screening(): ScreeningService
    {
        return $this->factory->screening();
    }

    public function securityChecks(): SecurityChecksRunner
    {
        return $this->factory->securityChecks();
    }
}
