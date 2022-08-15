<?php

namespace OpenSynergic\PaymentGateway\Gateways;

use OpenSynergic\PaymentGateway\Contracts\PaymentGateway;
use OpenSynergic\PaymentGateway\Enums\PaymentGatewayType;
use OpenSynergic\PaymentGateway\Filament\Pages\BankTransfer as PagesBankTransfer;

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

    public function getUrl()
    {
        return PagesBankTransfer::getRouteName();
    }
}