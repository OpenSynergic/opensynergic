<?php

namespace OpenSynergic\PaymentGateway\Facades;

use Illuminate\Support\Facades\Facade;
use OpenSynergic\PaymentGateway\Manager\PaymentGateway as PaymentGatewayManager;

/**
 * @see \OpenSynergic\PaymentGateway\Manager\PaymentGatewayManager
 */
class PaymentGateway extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PaymentGatewayManager::class;
    }
}