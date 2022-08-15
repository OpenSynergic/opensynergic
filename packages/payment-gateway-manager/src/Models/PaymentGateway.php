<?php

namespace OpenSynergic\PaymentGateway\Models;

use Illuminate\Database\Eloquent\Model;
use OpenSynergic\PaymentGateway\Contracts\PaymentGateway as PaymentGatewayContracts;
use OpenSynergic\PaymentGateway\Facades\PaymentGateway as FacadesPaymentGateway;
use Sushi\Sushi;

class PaymentGateway extends Model
{
    use Sushi;

    public function getRows()
    {
        return collect(FacadesPaymentGateway::getPaymentGetways())
            ->map(fn (PaymentGatewayContracts $gateway) => [
                'slug' => $gateway->getSlug(),
                'name' => $gateway->getName(),
                'type' => $gateway->type(),
                'url' => $gateway->getUrl(),
                'description' => $gateway->getDescription()
            ])
            ->values()
            ->toArray();
    }
}