<?php

namespace OpenSynergic\PaymentGateway\Manager;

use OpenSynergic\PaymentGateway\Contracts\PaymentGateway as PaymentGatewayContracts;
use OpenSynergic\PaymentGateway\Gateways\BankTransfer;

class PaymentGateway
{
    protected array $gateways = [];

    protected ?string $table;

    public function __construct()
    {
        $this->table('settings');
        $this->register(new BankTransfer());
    }

    public function getGateways()
    {
        return $this->gateway;
    }

    public function table($table)
    {
        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function register(PaymentGatewayContracts $gateway)
    {
        $this->gateways[$gateway->getSlug()] = $gateway;
    }

    public function getPaymentGetways(): array
    {
        return $this->gateways;
    }
}