<?php
namespace Tns\BridgerInsight\Laravel;

use Illuminate\Support\ServiceProvider;
use Tns\BridgerInsight\BridgerInsight;

class BridgerInsightServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config.php', 'bridger-insight');

        $this->app->singleton(BridgerInsight::class, function () {
            $envMap = [
                'BRIDGER_WSDL' => config('bridger-insight.wsdl'),
                'BRIDGER_CLIENT_ID' => config('bridger-insight.client_id'),
                'BRIDGER_USER_ID' => config('bridger-insight.user_id'),
                'BRIDGER_PASSWORD' => config('bridger-insight.password'),
                'BRIDGER_TIMEOUT' => (string) config('bridger-insight.timeout'),
                'BRIDGER_CACHE_WSDL' => config('bridger-insight.cache_wsdl') ? '1' : '0',
            ];
            foreach ($envMap as $k => $v) {
                if ($v !== null && $v !== '') {
                    putenv($k.'='.$v);
                }
            }
            return BridgerInsight::fromEnv();
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('bridger-insight.php'),
        ], 'bridger-config');
    }
}
