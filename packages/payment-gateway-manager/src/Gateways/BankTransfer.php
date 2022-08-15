<?php

namespace OpenSynergic\PaymentGateway\Gateways;

use OpenSynergic\PaymentGateway\Contracts\PaymentGateway;
use OpenSynergic\PaymentGateway\Enums\PaymentGatewayType;

class BankTransfer extends PaymentGateway
{
    protected string $slug = 'bank-transfer';
    
    protected ?string $name = 'Bank Transfer';

    public function init(): void
    {
        //
    }

    public function type(): PaymentGatewayType
    {
        return PaymentGatewayType::manually();
    }
}