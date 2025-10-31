<?php

namespace App\Dto;

use App\Models\ShippingRate;
use Illuminate\Support\Collection;

class ShippingRateDto
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $clientId,
        public readonly string $fromPostCode,
        public readonly string $toPostCode,
        public readonly string $fromWeight,
        public readonly string $toWeight,
        public readonly float $cost,
        public readonly int $branch = 1
    ) {}

    public static function fromCollection(Collection $shippingRate)
    {
        $numberFormatter = new \NumberFormatter('br', \NumberFormatter::DECIMAL);
        $numberFormatter->setPattern('####,##');

        return new static(
            $shippingRate['id'] ?? null,
            $shippingRate['client_id'],
            $shippingRate['from_postcode'],
            $shippingRate['to_postcode'],
            (float) $numberFormatter->parse($shippingRate['from_weight']),
            (float) $numberFormatter->parse($shippingRate['to_weight']),
            (float) $numberFormatter->parse($shippingRate['cost']),
            $shippingRate['branch'] ?? 1
        );
    }

    public static function fromModel(ShippingRate $shippingRate)
    {
        return new static(
            $shippingRate->id,
            $shippingRate->client_id,
            $shippingRate->from_postcode,
            $shippingRate->to_postcode,
            $shippingRate->from_weight,
            $shippingRate->to_weight,
            $shippingRate->cost,
            $shippingRate->branch
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'client_id' => $this->clientId,
            'from_postcode' => $this->fromPostCode,
            'to_postcode' => $this->toPostCode,
            'from_weight' => $this->fromWeight,
            'to_weight' => $this->toWeight,
            'cost' => $this->cost,
            'branch' => $this->branch,
        ];
    }
}
