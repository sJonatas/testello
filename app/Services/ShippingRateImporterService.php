<?php

namespace App\Services;

use App\Dto\ShippingRateDto;
use App\Models\ShippingRate;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ShippingRateImporterService implements ToCollection, WithHeadingRow
{
    use Importable {
        Importable::import as importFile;
    }

    protected $clientId = null;

    public function __construct(
        protected ShippingRateService $shippingRateService
    ) {
        HeadingRowFormatter::default('none');
    }

    public function forClient(int $clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function collection(Collection $collection)
    {
        $shippingRates = $this->shippingRateService->fromClient($this->clientId);

        try {
            $collection->chunk(10)->each(function (Collection $rows) use ($shippingRates) {
                $rows->each(function (Collection $row) use ($shippingRates) {
                    /** @var ShippingRate|null $rate */
                    $rate = (clone $shippingRates)
                        ->where(['from_postcode' => $row['from_postcode']])
                        ->where(['to_postcode' => $row['to_postcode']])
                        ->first();

                    if ($rate) {
                        $rate = ShippingRateDto::fromModel($rate);

                        $this->shippingRateService->save(ShippingRateDto::fromCollection(collect([
                            ...$rate->toArray(),
                            ...$row,
                        ])));
                    } else {
                        $rate = ShippingRateDto::fromCollection(collect([
                            ...$row,
                            'client_id' => $this->clientId,
                        ]));

                        $this->shippingRateService->save($rate);
                    }
                });
            });
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    protected function validateClient()
    {
        if (! $this->clientId) {
            throw new \Exception('The client id must be provided.');
        }
    }

    protected function validateHeaders(string $filepath)
    {
        $headings = collect((new HeadingRowImport)->toArray($filepath))->first();
        if (count($headings) !== 1) {
            throw new \Exception('Headers are not defined.');
        }

        $required = ['from_weight', 'to_weight', 'from_postcode', 'to_postcode', 'cost'];
        foreach ($required as $key) {
            if (! in_array($key, $headings[0])) {
                throw new \Exception('Verify the headers names. Missing: '.$key);
            }
        }
    }

    /**
     * @return \Illuminate\Foundation\Bus\PendingDispatch|\Maatwebsite\Excel\Importer
     *
     * @throws \Exception
     */
    public function import($filePath = null, ?string $disk = null, ?string $readerType = null)
    {
        $this->validateClient();
        $this->validateHeaders($filePath);

        return $this->importFile($filePath, $disk, $readerType);
    }
}
