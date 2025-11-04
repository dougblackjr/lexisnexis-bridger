<?php
namespace Tns\BridgerInsight\Soap;

use SoapHeader;
use SoapVar;

final class WsseMiddleware
{
    public static function usernameToken(string $clientId, string $userId, string $password): SoapHeader
    {
        // Namespace can vary per WSDL. This commonly works with WCF stacks.
        $ns = 'http://schemas.xmlsoap.org/ws/2002/12/secext';
        $xml = sprintf(
            '<wsse:Security xmlns:wsse="%1$s">
               <wsse:UsernameToken>
                 <wsse:Username>%2$s\%3$s</wsse:Username>
                 <wsse:Password>%4$s</wsse:Password>
               </wsse:UsernameToken>
             </wsse:Security>',
            $ns,
            htmlspecialchars($clientId, ENT_XML1),
            htmlspecialchars($userId, ENT_XML1),
            htmlspecialchars($password, ENT_XML1)
        );

        return new SoapHeader($ns, 'Security', new SoapVar($xml, XSD_ANYXML), true);
    }
}
