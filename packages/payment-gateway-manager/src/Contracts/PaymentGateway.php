<?php

namespace OpenSynergic\PaymentGateway\Contracts;

use OpenSynergic\PaymentGateway\Enums\PaymentGatewayType;

abstract class PaymentGateway
{
    protected string $slug;
    protected ?string $name;
    protected ?string $description;
    // protected ?string $view;

    abstract public function init(): void;

    abstract public function type(): PaymentGatewayType;

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): string|null
    {
        return $this->description ?? null;
    }
}