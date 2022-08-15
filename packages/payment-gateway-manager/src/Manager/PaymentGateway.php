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
        $this->table(config('payment-gateways.table') ?? 'settings');
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

    public function register(string|array $classes): void
    {
        if (!is_array($classes) ) {
            $classes = (array) $classes;
        }

        foreach($classes as $class) {
            $this->setPaymentGetways(new $class());
        }
    }

    protected function setPaymentGetways(PaymentGatewayContracts $gateway)
    {
        $this->gateways[$gateway::class] = $gateway;
    }

    public function getPaymentGetways(): array
    {
        return $this->gateways;
    }
}