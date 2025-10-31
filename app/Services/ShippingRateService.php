<?php

namespace App\Services;

use App\Dto\ShippingRateDto;
use App\Models\ShippingRate;
use Illuminate\Database\Eloquent\Builder;

class ShippingRateService
{
    public function __construct(
        protected ShippingRate $shippingRate
    ) {}

    public function fromClient(int $id): Builder
    {
        return $this->shippingRate
            ->query()
            ->where(['client_id' => $id]);
    }

    /**
     * @return bool
     */
    public function save(ShippingRateDto $shippingRate)
    {
        $attributes = $shippingRate->toArray();

        if (! empty($attributes['id'])) {
            $model = $this->shippingRate->newQuery()->find($attributes['id']);
            if ($model) {
                $model->fill($attributes);

                return $model->save();
            }
        }

        return $this->shippingRate->newQuery()->create($attributes)->exists;
    }
}
