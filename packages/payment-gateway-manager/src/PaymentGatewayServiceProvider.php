<?php

namespace OpenSynergic\PaymentGateway;

use Filament\PluginServiceProvider;
use OpenSynergic\PaymentGateway\Contracts\PaymentGateway as PaymentGatewayContracts;
use OpenSynergic\PaymentGateway\Facades\PaymentGateway as FacadesPaymentGateway;
use OpenSynergic\PaymentGateway\Filament\Pages\Settings\PaymentGateway;
use OpenSynergic\PaymentGateway\Gateways\BankTransfer;
use OpenSynergic\PaymentGateway\Manager\PaymentGateway as PaymentGatewayManager;
use Spatie\LaravelPackageTools\Package;

class PaymentGatewayServiceProvider extends PluginServiceProvider
{
    public static string $name = 'payment-gateway-manager';

    protected array $pages = [
        PaymentGateway::class
    ];

    public function configurePackage(Package $package): void
    {
        parent::configurePackage($package);
    }

    public function packageBooted(): void
    {
        parent::packageBooted();
    }

    public function packageRegistered(): void
    {
        parent::packageRegistered();

        $this->app->beforeResolving('filament', function () {
            $this->app->make(PaymentGatewayManager::class);
        });

        $this->app->resolving(PaymentGatewayManager::class, function (): void {
            $this->discoverPlugins();
        });

        $this->app->scoped(PaymentGatewayManager::class, function (): PaymentGatewayManager {
            return new PaymentGatewayManager();
        });
    }

    public function discoverPlugins(): void
    {
        // FacadesPaymentGateway::register();
        // dd(collect(get_declared_classes())->filter(fn ($class) => $class == PaymentGatewayContracts::class));
    }
}