<?php
namespace Tns\BridgerInsight\Soap;

use SoapClient;
use SoapFault;

final class RuntimeSoapClient
{
    public static function make(string $wsdl, array $options = []): SoapClient
    {
        if (!$wsdl) {
            throw new \InvalidArgumentException('WSDL is required. Set BRIDGER_WSDL or pass a value.');
        }

        $defaults = [
            'trace' => false,
            'exceptions' => true,
            'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
            'cache_wsdl' => WSDL_CACHE_BOTH,
            'connection_timeout' => 15,
            'stream_context' => stream_context_create([
                'http' => ['user_agent' => 'TNS-Bridger-Client/1.0'],
            ]),
        ];

        $opts = $options + $defaults;

        try {
            return new SoapClient($wsdl, $opts);
        } catch (SoapFault $e) {
            throw $e;
        }
    }
}
