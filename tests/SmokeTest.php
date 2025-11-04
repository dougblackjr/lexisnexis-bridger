<?php
namespace Tns\BridgerInsight\Tests;

use PHPUnit\Framework\TestCase;
use Tns\BridgerInsight\Dto\ScreeningRequest;

final class SmokeTest extends TestCase
{
    public function testDto(): void
    {
        $req = (new ScreeningRequest())->person()->name('Jane', 'Doe')->dob('1980-01-01');
        $this->assertSame('Person', $req->type);
        $this->assertSame('Jane', $req->givenName);
    }
}
