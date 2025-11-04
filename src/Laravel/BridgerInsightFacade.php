<?php
namespace Tns\BridgerInsight\Laravel;

use Illuminate\Support\Facades\Facade;
use Tns\BridgerInsight\BridgerInsight;

/**
 * @method static \Tns\BridgerInsight\Services\ScreeningService screening()
 * @method static \Tns\BridgerInsight\Services\SecurityChecksRunner securityChecks()
 */
class BridgerInsightFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BridgerInsight::class;
    }
}
